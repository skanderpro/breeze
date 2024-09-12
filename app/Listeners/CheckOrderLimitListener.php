<?php
// app/Listeners/CheckOrderLimitListener.php
namespace App\Listeners;

use App\Events\CheckOrderLimit;
use Illuminate\Support\Facades\Auth;

class CheckOrderLimitListener
{
  public function handle(CheckOrderLimit $event)
  {
    $user = Auth::user();
    $orderAmount = $event->po->poValue;
    $limit = $user->order_limit;

    if ($orderAmount > $limit) {
      $event->po->overlimit_value = $orderAmount - $limit;
      $event->po->save();
    }
  }
}
