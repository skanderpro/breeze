<?php
// app/Listeners/DuplicateCompany.php
namespace App\Listeners;

use App\Events\CompanyCreated;
use App\Models\Company;

class DuplicateCompany
{
  public function handle(CompanyCreated $event)
  {
    $originalCompany = $event->company;

    if ($originalCompany->parent_id === 0) {
      $duplicateCompany = $originalCompany->replicate();
      $duplicateCompany->parent_id = $originalCompany->id;
      $duplicateCompany->save();
    }
  }
}
