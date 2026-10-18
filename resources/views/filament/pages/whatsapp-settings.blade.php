<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex flex-wrap items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <x-filament::button type="submit" color="primary" icon="heroicon-o-check">
                Simpan Konfigurasi
            </x-filament::button>

            <x-filament::button type="button" wire:click="testSend" color="success" icon="heroicon-o-paper-airplane">
                Kirim Pesan Uji Coba Sekarang
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
