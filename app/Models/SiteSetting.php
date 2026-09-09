<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Sosyal bağlantı anahtarları.
     *
     * @return list<string>
     */
    public static function socialKeys(): array
    {
        return ['linkedin_url', 'github_url', 'twitter_url'];
    }

    public static function getValue(string $key, ?string $default = null): ?string
    {
        $settings = static::cached();

        $value = $settings[$key] ?? $default;

        return $value !== null && $value !== '' ? $value : $default;
    }

    /**
     * @param  array<string, string|null>  $pairs
     */
    public static function setMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            static::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value !== null && $value !== '' ? trim($value) : null]
            );
        }

        Cache::forget('site_settings');
    }

    /**
     * @return array<string, string|null>
     */
    public static function cached(): array
    {
        return Cache::rememberForever('site_settings', function () {
            return static::query()->pluck('value', 'key')->all();
        });
    }

    /**
     * @return array{linkedin_url: ?string, github_url: ?string, twitter_url: ?string}
     */
    public static function socialLinks(): array
    {
        return [
            'linkedin_url' => static::getValue('linkedin_url'),
            'github_url' => static::getValue('github_url'),
            'twitter_url' => static::getValue('twitter_url'),
        ];
    }
}
