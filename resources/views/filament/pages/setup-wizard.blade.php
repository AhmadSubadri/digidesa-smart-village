<x-filament-panels::page>
    <div class="mb-4 p-4 rounded-2xl bg-primary-50 dark:bg-primary-950/40 border border-primary-200 dark:border-primary-800">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-600 text-white flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-primary-950 dark:text-primary-100">Setup Wizard Onboarding DesaHub (1 Desa 1 Sistem)</h3>
                <p class="text-xs text-primary-700 dark:text-primary-300 mt-0.5">
                    Gunakan wizard ini untuk mengonfigurasi identitas wilayah, nama kepala desa, tanda tangan digital, stempel, dan tema warna saat memasang sistem di desa baru dalam hitungan menit.
                </p>
            </div>
        </div>
    </div>

    <form wire:submit="save">
        {{ $this->form }}
    </form>
</x-filament-panels::page>
