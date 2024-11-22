<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\MerchantRestrictJob;

class RunUpdateMerchantRestrictJob extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "job:run-update-merchant-restrict-job";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = "Command description";

  /**
   * Execute the console command.
   */
  public function handle()
  {
    MerchantRestrictJob::dispatch();
  }
}
