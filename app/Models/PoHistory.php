<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoHistory extends Model
{
  use HasFactory;

  protected $fillable = ["action", "data", "user_id", "po_id"];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function getFormattedDataAttribute()
  {
    switch ($this->action) {
      case "Document":
      case "Uploaded POD":
        return url($this->data);
      default:
        return $this->data;
    }
  }
}
