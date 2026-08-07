<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class SettingService
{
    protected int $cacheTtl = 3600; // 1 hour

    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting.{$key}", $this->cacheTtl, function () use ($key, $default) {
            $setting = Setting::where('key', $key)->first();

            if (!$setting) {
                return $default;
            }

            return $this->castValue($setting->value, $setting->type);
        });
    }

    public function set(string $key, mixed $value): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value) : $value]
        );

        Cache::forget("setting.{$key}");
        Cache::forget('settings.all');
    }

    public function getGroup(string $group): \Illuminate\Support\Collection
    {
        return Cache::remember("settings.group.{$group}", $this->cacheTtl, function () use ($group) {
            return Setting::where('group', $group)
                ->orderBy('sort_order')
                ->get()
                ->mapWithKeys(fn ($setting) => [
                    $setting->key => $this->castValue($setting->value, $setting->type)
                ]);
        });
    }

    public function clearCache(string $key = null): void
    {
        if ($key) {
            Cache::forget("setting.{$key}");
        } else {
            // Clear all setting caches
            Setting::all()->each(fn ($s) => Cache::forget("setting.{$s->key}"));
            Cache::forget('settings.all');

            foreach (['general', 'contact', 'social', 'seo', 'appearance'] as $group) {
                Cache::forget("settings.group.{$group}");
            }
        }
    }

    protected function castValue(mixed $value, string $type): mixed
    {
        return match ($type) {
            'boolean' => (bool) $value,
            'number'  => (float) $value,
            'json'    => json_decode($value, true),
            default   => $value,
        };
    }
}
