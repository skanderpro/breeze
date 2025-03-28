<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\CheckOrderLimit;
use App\Listeners\CheckOrderLimitListener;
use App\Events\CompanyCreated;
use App\Listeners\DuplicateCompany;
use App\Models\Po;
use App\Observers\PoObserver;

class EventServiceProvider extends ServiceProvider
{
  /**
   * The event to listener mappings for the application.
   *
   * @var array<class-string, array<int, class-string>>
   */
  protected $listen = [
    Registered::class => [SendEmailVerificationNotification::class],
    CheckOrderLimit::class => [CheckOrderLimitListener::class],
    CompanyCreated::class => [DuplicateCompany::class],
  ];

  /**
   * Register any events for your application.
   */
  public function boot(): void
  {
    parent::boot();
    Po::observe(PoObserver::class);
  }

  /**
   * Determine if events and listeners should be automatically discovered.
   */
  public function shouldDiscoverEvents(): bool
  {
    return false;
  }
}
