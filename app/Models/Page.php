<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $table = 'content_pages';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
    ];

    public function setTitleAttribute($value)
    {
        $slug = Str::slug($value);
        $existingPage = static::getPageBySlug($slug);
        if ($existingPage && $existingPage->id != $this->id) {
            $slug .= (string)now()->timestamp;
        }

        $this->attributes['title'] = $value;
        $this->attributes['slug'] = $slug;
    }

    public static function getPageBySlug($slug)
    {
        return static::query()->where('slug', $slug)->first();
    }
}
