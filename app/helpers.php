<?php

use App\Services\SettingService;

if (!function_exists('setting')) {
    /**
     * Get a setting value from the database.
     * Supports dot notation for JSON values: setting('social_media.instagram')
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function setting(string $key, mixed $default = null): mixed
    {
        // Support dot notation for nested JSON values
        if (str_contains($key, '.')) {
            [$rootKey, $subKey] = explode('.', $key, 2);
            $value = app(SettingService::class)->get($rootKey, []);

            if (is_array($value)) {
                return data_get($value, $subKey, $default);
            }

            return $default;
        }

        return app(SettingService::class)->get($key, $default);
    }
}

if (!function_exists('placeholder_image')) {
    /**
     * Generate an ultra-fast, zero-network inline SVG placeholder image.
     */
    function placeholder_image(int $width = 800, int $height = 500, string $title = 'Pemerintah Kalurahan'): string
    {
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="'.$width.'" height="'.$height.'" viewBox="0 0 '.$width.' '.$height.'">'
            .'<defs>'
            .'<linearGradient id="g" x1="0%" y1="0%" x2="100%" y2="100%">'
            .'<stop offset="0%" stop-color="#0F294A"/>'
            .'<stop offset="100%" stop-color="#1E3A8A"/>'
            .'</linearGradient>'
            .'</defs>'
            .'<rect width="100%" height="100%" fill="url(#g)"/>'
            .'<circle cx="'.($width/2).'" cy="'.($height/2 - 20).'" r="32" fill="#3B82F6" opacity="0.3"/>'
            .'<text x="50%" y="'.($height/2 + 25).'%" fill="#93C5FD" font-family="system-ui, sans-serif" font-size="14" font-weight="600" text-anchor="middle">'.htmlspecialchars($title).'</text>'
            .'</svg>';

        return 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);
    }
}

