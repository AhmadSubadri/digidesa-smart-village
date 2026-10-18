<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Services\WhatsappService;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class WhatsappSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Pengaturan Sistem';
    protected static ?string $navigationLabel = 'WhatsApp Gateway';
    protected static ?string $title = 'Integrasi WhatsApp Gateway & Notifikasi';
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.whatsapp-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'whatsapp_provider' => setting('whatsapp_provider', 'mock'),
            'whatsapp_api_token' => setting('whatsapp_api_token', ''),
            'whatsapp_sender_number' => setting('whatsapp_sender_number', ''),
            'whatsapp_notify_letter_submitted' => setting('whatsapp_notify_letter_submitted', '1') === '1',
            'whatsapp_notify_letter_approved' => setting('whatsapp_notify_letter_approved', '1') === '1',
            'whatsapp_notify_letter_rejected' => setting('whatsapp_notify_letter_rejected', '1') === '1',
            'test_phone' => '',
            'test_message' => 'Halo dari Sistem Informasi Desa! Ini adalah pesan uji coba integrasi WhatsApp Gateway.',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Konfigurasi Layanan WhatsApp Gateway')
                    ->description('Pilih penyedia layanan WhatsApp API resmi yang digunakan oleh kantor desa untuk pengiriman pesan otomatis ke warga.')
                    ->schema([
                        Radio::make('whatsapp_provider')
                            ->label('Penyedia Layanan (Gateway Provider)')
                            ->options([
                                'mock' => 'Simulasi (Mock Driver - Cocok untuk Testing / Demo tanpa pulsa/kuota API)',
                                'fonnte' => 'Fonnte (Rekomendasi Indonesia - Mendukung webhook & blast berlisensi)',
                                'wablas' => 'Wablas (API WhatsApp Business Multi-device)',
                            ])
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('whatsapp_api_token')
                            ->label('API Token / Auth Secret')
                            ->password()
                            ->revealable()
                            ->helperText('Masukkan token API dari dashboard provider yang Anda pilih.'),

                        TextInput::make('whatsapp_sender_number')
                            ->label('Nomor WhatsApp Pengirim / Server Desa')
                            ->placeholder('Contoh: 081234567890')
                            ->helperText('Nomor WhatsApp yang terhubung di perangkat gateway desa.'),
                    ])->columns(2),

                Section::make('Otomasi Notifikasi Surat')
                    ->description('Tentukan kejadian persuratan yang akan secara otomatis mengirim notifikasi ke nomor WhatsApp pemohon.')
                    ->schema([
                        Toggle::make('whatsapp_notify_letter_submitted')
                            ->label('Kirim saat permohonan surat baru diajukan (Nomor Tiket & Status Awal)')
                            ->default(true),

                        Toggle::make('whatsapp_notify_letter_approved')
                            ->label('Kirim saat surat disahkan & terbit (Nomor Surat Resmi & Tautan Unduh PDF)')
                            ->default(true),

                        Toggle::make('whatsapp_notify_letter_rejected')
                            ->label('Kirim saat surat ditolak / perlu perbaikan berkas (Disertai Alasan Petugas)')
                            ->default(true),
                    ]),

                Section::make('Uji Coba Pengiriman Pesan Langsung')
                    ->description('Kirim pesan uji coba untuk memastikan koneksi ke perangkat WhatsApp desa berhasil.')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('test_phone')
                                ->label('Nomor WhatsApp Tujuan')
                                ->placeholder('Contoh: 081298765432')
                                ->columnSpan(1),

                            TextInput::make('test_message')
                                ->label('Teks Pesan Uji Coba')
                                ->columnSpan(2),
                        ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::updateOrCreate(['key' => 'whatsapp_provider'], ['group' => 'whatsapp', 'value' => $data['whatsapp_provider'] ?? 'mock']);
        Setting::updateOrCreate(['key' => 'whatsapp_api_token'], ['group' => 'whatsapp', 'value' => $data['whatsapp_api_token'] ?? '']);
        Setting::updateOrCreate(['key' => 'whatsapp_sender_number'], ['group' => 'whatsapp', 'value' => $data['whatsapp_sender_number'] ?? '']);
        Setting::updateOrCreate(['key' => 'whatsapp_notify_letter_submitted'], ['group' => 'whatsapp', 'value' => !empty($data['whatsapp_notify_letter_submitted']) ? '1' : '0']);
        Setting::updateOrCreate(['key' => 'whatsapp_notify_letter_approved'], ['group' => 'whatsapp', 'value' => !empty($data['whatsapp_notify_letter_approved']) ? '1' : '0']);
        Setting::updateOrCreate(['key' => 'whatsapp_notify_letter_rejected'], ['group' => 'whatsapp', 'value' => !empty($data['whatsapp_notify_letter_rejected']) ? '1' : '0']);

        Notification::make()
            ->title('Pengaturan WhatsApp Berhasil Disimpan')
            ->body('Konfigurasi gateway notifikasi persuratan desa telah diperbarui.')
            ->success()
            ->send();
    }

    public function testSend(): void
    {
        $data = $this->form->getState();
        $target = $data['test_phone'] ?? '';
        $message = $data['test_message'] ?? 'Tes pesan WhatsApp DesaHub.';

        if (empty($target)) {
            Notification::make()
                ->title('Nomor Tujuan Kosong')
                ->body('Harap isi nomor WhatsApp tujuan uji coba terlebih dahulu.')
                ->warning()
                ->send();
            return;
        }

        // Simpan konfigurasi terkini sebelum kirim
        $this->save();

        $waService = app(WhatsappService::class);
        $result = $waService->sendDirect($target, $message);

        if ($result['status'] ?? false) {
            Notification::make()
                ->title('Uji Coba Berhasil!')
                ->body($result['message'])
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Uji Coba Gagal')
                ->body($result['message'])
                ->danger()
                ->send();
        }
    }
}
