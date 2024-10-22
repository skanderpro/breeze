<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PoDocument extends Model
{
  use HasFactory;
  protected $fillable = ["document", "po_id"];

  public function po()
  {
    return $this->belongsTo(Po::class);
  }

  protected static function boot()
  {
    parent::boot();

    static::created(function ($model) {
      $user = Auth::user();
      PoHistory::create([
        "action" => "Document",
        "data" => $model->document,
        "user_id" => $user->id,
        "po_id" => $model->po_id,
      ]);
    });
  }
}
