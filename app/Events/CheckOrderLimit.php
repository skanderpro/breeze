<?php
// app/Events/CheckOrderLimit.php
namespace App\Events;

use App\Models\Po;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckOrderLimit
{
  use Dispatchable, SerializesModels;

  public $po;

  public function __construct(Po $po)
  {
    $this->po = $po;
  }
}
