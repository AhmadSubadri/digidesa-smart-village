<?php

namespace App\Filament\Pages;

use App\Services\SettingService;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SetupWizard extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Pengaturan Sistem';

    protected static ?string $navigationLabel = 'Setup Wizard Desa (Onboarding)';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.setup-wizard';

    public ?array $data = [];

    public function mount(): void
    {
        $service = app(SettingService::class);
        $this->form->fill([
            'village_name'   => $service->get('village_name', 'Desa Digital'),
            'village_code'   => $service->get('village_code', '34.04.07.2001'),
            'district_name'  => $service->get('district_name', 'Kecamatan Contoh'),
            'regency_name'   => $service->get('regency_name', 'Kabupaten Sleman'),
            'province_name'  => $service->get('province_name', 'D.I. Yogyakarta'),
            'contact_address'=> $service->get('contact_address', 'Jl. Raya Desa No. 1'),
            'contact_phone'  => $service->get('contact_phone', '(021) 12345678'),
            'contact_email'  => $service->get('contact_email', 'kontak@desa.id'),

            'leader_name'    => $service->get('leader_name', 'H. Nama Kepala Desa'),
            'leader_title'   => $service->get('leader_title', 'Kepala Desa'),
            'leader_nip'     => $service->get('leader_nip', '-'),
            'secretary_name' => $service->get('secretary_name', 'Nama Sekretaris Desa'),

            'theme_color'    => $service->get('theme_color_primary', '#1B4F72'),
            'site_tagline'   => $service->get('site_tagline', 'Smart Village Ecosystem & Pusat Layanan Mandiri Desa'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    // LANGKAH 1
                    Forms\Components\Wizard\Step::make('Identitas Wilayah')
                        ->description('Nama desa, kode Kemendagri, dan kontak resmi')
                        ->icon('heroicon-o-building-library')
                        ->schema([
                            Forms\Components\TextInput::make('village_name')
                                ->label('Nama Desa / Kalurahan')
                                ->required()
                                ->maxLength(100),
                            Forms\Components\TextInput::make('village_code')
                                ->label('Kode Wilayah Kemendagri')
                                ->placeholder('e.g. 34.04.07.2001')
                                ->helperText('Format standar 10 digit kode wilayah Kemendagri')
                                ->required(),
                            Forms\Components\TextInput::make('district_name')
                                ->label('Kapanewon / Kecamatan')
                                ->required(),
                            Forms\Components\TextInput::make('regency_name')
                                ->label('Kabupaten / Kota')
                                ->required(),
                            Forms\Components\TextInput::make('province_name')
                                ->label('Provinsi')
                                ->required(),
                            Forms\Components\Textarea::make('contact_address')
                                ->label('Alamat Kantor Desa')
                                ->required(),
                            Forms\Components\TextInput::make('contact_phone')
                                ->label('Nomor Telepon Kantor'),
                            Forms\Components\TextInput::make('contact_email')
                                ->label('Email Resmi Desa')
                                ->email(),
                        ])->columns(2),

                    // LANGKAH 2
                    Forms\Components\Wizard\Step::make('Pamong & Penandatangan')
                        ->description('Data Kepala Desa & berkas pengesahan')
                        ->icon('heroicon-o-user-group')
                        ->schema([
                            Forms\Components\TextInput::make('leader_title')
                                ->label('Sebutan Pimpinan (Kades / Lurah / Petinggi)')
                                ->default('Kepala Desa')
                                ->required(),
                            Forms\Components\TextInput::make('leader_name')
                                ->label('Nama Lengkap Pimpinan Beserta Gelar')
                                ->required(),
                            Forms\Components\TextInput::make('leader_nip')
                                ->label('NIP / NRP (Jika Ada)')
                                ->placeholder('NIP atau nomor register'),
                            Forms\Components\TextInput::make('secretary_name')
                                ->label('Nama Sekretaris Desa (Sekdes / Carik)')
                                ->required(),
                            Forms\Components\FileUpload::make('seal_path')
                                ->label('Upload Scan Stempel Resmi Desa (PNG Transparan)')
                                ->disk('public')
                                ->directory('branding')
                                ->image(),
                            Forms\Components\FileUpload::make('signature_path')
                                ->label('Upload Scan Tanda Tangan Pimpinan (PNG Transparan)')
                                ->disk('public')
                                ->directory('branding')
                                ->image(),
                        ])->columns(2),

                    // LANGKAH 3
                    Forms\Components\Wizard\Step::make('Visual & Branding')
                        ->description('Logo, slogan, dan warna tema website')
                        ->icon('heroicon-o-paint-brush')
                        ->schema([
                            Forms\Components\TextInput::make('site_tagline')
                                ->label('Slogan / Tagline Website')
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\Select::make('theme_preset')
                                ->label('Pilihan Preset Warna Tema')
                                ->options([
                                    '#1B4F72' => 'Emerald Gov (Hijau Pemerintahan Modern)',
                                    '#1E40AF' => 'Ocean Blue (Biru Maritim Dinamis)',
                                    '#991B1B' => 'Royal Maroon (Merah Elegan)',
                                    '#0F172A' => 'Modern Slate (Abu-Abu Minimalis)',
                                ])
                                ->default('#1B4F72')
                                ->live()
                                ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('theme_color', $state)),
                            Forms\Components\ColorPicker::make('theme_color')
                                ->label('Warna Primer Kustom')
                                ->required(),
                            Forms\Components\FileUpload::make('logo_path')
                                ->label('Upload Logo Pemda / Desa')
                                ->disk('public')
                                ->directory('branding')
                                ->image(),
                            Forms\Components\FileUpload::make('favicon_path')
                                ->label('Upload Favicon (.ico / .png)')
                                ->disk('public')
                                ->directory('branding')
                                ->image(),
                        ])->columns(2),
                ])
                ->submitAction(new \Illuminate\Support\HtmlString(
                    '<button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-sm shadow-md transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Terapkan Konfigurasi Desa</span>
                    </button>'
                )),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $service = app(SettingService::class);

        foreach ($state as $key => $value) {
            if ($value !== null && $key !== 'theme_preset') {
                $service->set($key, $value);
            }
        }

        // Tandai sistem sudah dikonfigurasi
        $service->set('is_installed', true);
        $service->clearCache();

        Notification::make()
            ->title('Konfigurasi Desa Berhasil Diterapkan!')
            ->body("Identitas {$state['village_name']} telah aktif di seluruh sistem.")
            ->success()
            ->send();
    }
}
