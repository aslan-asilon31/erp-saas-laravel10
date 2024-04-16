<?php

namespace App\Providers;

use App\Events\CompanyConfigured;
use App\Events\CompanyDefaultEvent;
use App\Events\CompanyDefaultUpdated;
use App\Events\CompanyGenerated;
use App\Events\CurrencyRateChanged;
use App\Events\DefaultCurrencyChanged;
use App\Listeners\ConfigureCompanyDefault;
use App\Listeners\ConfigureCompanyNavigation;
use App\Listeners\CreateCompanyDefaults;
use App\Listeners\SyncAssociatedModels;
use App\Listeners\SyncWithCompanyDefaults;
use App\Listeners\UpdateAccountBalances;
use App\Listeners\UpdateCurrencyRates;
use App\Models\Banking\Account;
use App\Models\Setting\Currency;
use App\Observers\AccountObserver;
use App\Observers\CurrencyObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CompanyDefaultEvent::class => [
            SyncWithCompanyDefaults::class,
        ],
        CompanyDefaultUpdated::class => [
            SyncAssociatedModels::class,
        ],
        CompanyConfigured::class => [
            ConfigureCompanyDefault::class,
            ConfigureCompanyNavigation::class,
        ],
        CompanyGenerated::class => [
            CreateCompanyDefaults::class,
        ],
        DefaultCurrencyChanged::class => [
            UpdateCurrencyRates::class,
        ],
        CurrencyRateChanged::class => [
            UpdateAccountBalances::class,
        ],
    ];

    /**
     * The model observers to register.
     *
     * @var array<string, string|object|array<int, string|object>>
     */
    protected $observers = [
        Currency::class => [CurrencyObserver::class],
        Account::class => [AccountObserver::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
