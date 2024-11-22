<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Merchant;

class MerchantRestrictJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   */
  public function __construct()
  {
    //
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    $models = Merchant::all();

    for ($i = 0; $i < count($models); $i++) {
      if ($this->calculateMerchantOther($models[$i])) {
        $models[$i]->merchantOther = "YES";
        $models[$i]->update();
      }
    }
  }

  private function calculateMerchantOther($model)
  {
    if (
      $model->merchantDecorating === "YES" ||
      $model->merchantFlooring === "YES" ||
      $model->merchantAuto === "YES" ||
      $model->merchantAggregate === "YES" ||
      $model->merchantRoofing === "YES" ||
      $model->merchantFixings === "YES" ||
      $model->merchantIronmongery === "YES" ||
      $model->merchantTyres === "YES" ||
      $model->merchantHealth === "YES"
    ) {
      return true;
    }
    return false;
  }
}
