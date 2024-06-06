<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $key
 * @property string $group
 * @property mixed $value
 */
class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'value',
    ];

    public function getRouteKeyName()
    {
        return 'key';
    }

    public static function set($key, $value = null, $group = null)
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
            ]
        );
    }

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) {
            return $default;
        }

        return $setting->value;
    }

    public static function getInt(string $key, int $default = 0): int
    {
        return (int)static::get($key, $default);
    }

    public static function getGroup($group)
    {
        return static::query()
            ->where('group', $group)
            ->get();
    }
}
