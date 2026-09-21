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
    function placeholder_image(int $width = 800, int $height = 500, string $title = 'Kalurahan Condongcatur'): string
    {
        $safeTitle = htmlspecialchars(mb_strimwidth($title, 0, 45, '...'), ENT_QUOTES, 'UTF-8');
        $centerY = (int)($height / 2);
        $centerX = (int)($width / 2);
        $iconY = $centerY - 24;
        $textY = $centerY + 28;

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="'.$width.'" height="'.$height.'" viewBox="0 0 '.$width.' '.$height.'">'
            .'<defs>'
            .'<linearGradient id="g" x1="0%" y1="0%" x2="100%" y2="100%">'
            .'<stop offset="0%" stop-color="#0F294A"/>'
            .'<stop offset="50%" stop-color="#143660"/>'
            .'<stop offset="100%" stop-color="#1E3A8A"/>'
            .'</linearGradient>'
            .'</defs>'
            .'<rect width="100%" height="100%" fill="url(#g)"/>'
            .'<rect width="100%" height="100%" fill="none" stroke="#3B82F6" stroke-width="2" opacity="0.15"/>'
            .'<g transform="translate('.($centerX - 24).', '.$iconY.')" stroke="#93C5FD" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round" opacity="0.8">'
            .'<path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" transform="scale(2) translate(0, -6)"/>'
            .'</g>'
            .'<text x="50%" y="'.$textY.'" fill="#E2E8F0" font-family="-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif" font-size="13" font-weight="600" text-anchor="middle" letter-spacing="0.3">'.$safeTitle.'</text>'
            .'<text x="50%" y="'.($textY + 18).'" fill="#60A5FA" font-family="-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif" font-size="10" font-weight="700" text-anchor="middle" letter-spacing="1" text-transform="uppercase">PORTAL RESMI KALURAHAN</text>'
            .'</svg>';

        return 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);
    }
}

