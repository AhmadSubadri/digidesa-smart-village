<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class SettingService
{
    protected int $cacheTtl = 86400; // 24 hours
    protected static ?array $memoizedSettings = null;

    public static function getValue(string $key, mixed $default = null): mixed
    {
        return (new static())->get($key, $default);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $all = $this->all();
        return $all[$key] ?? $default;
    }

    public function all(): array
    {
        if (static::$memoizedSettings !== null) {
            return static::$memoizedSettings;
        }

        static::$memoizedSettings = Cache::remember('settings.all_keyed', $this->cacheTtl, function () {
            try {
                return Setting::all()->mapWithKeys(function ($s) {
                    return [$s->key => $this->castValue($s->value, $s->type)];
                })->toArray();
            } catch (\Throwable) {
                return [];
            }
        });

        return static::$memoizedSettings;
    }

    public function set(string $key, mixed $value): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value) : $value]
        );

        $this->clearCache();
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
        static::$memoizedSettings = null;
        Cache::forget('settings.all_keyed');
        Cache::forget('settings.all');

        foreach (['general', 'contact', 'social', 'seo', 'appearance'] as $group) {
            Cache::forget("settings.group.{$group}");
        }
    }

    protected function castValue(mixed $value, string $type): mixed
    {
        return match ($type) {
            'boolean' => (bool) $value,
            'number'  => (float) $value,
            'json'    => is_string($value) ? json_decode($value, true) : (array) $value,
            default   => $value,
        };
    }
}

