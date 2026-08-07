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
