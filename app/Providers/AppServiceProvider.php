<?php

namespace App\Providers;

use App\Events\BantuanStatusChanged;
use App\Events\DataExportRequested;
use App\Events\LaporanStatusChanged;
use App\Listeners\HandleBantuanStatusChange;
use App\Listeners\HandleDataExportRequest;
use App\Listeners\HandleLaporanStatusChange;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register repositories
        $this->app->singleton(\App\Repositories\BantuanRepository::class);
        $this->app->singleton(\App\Repositories\LaporanRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register event listeners
        Event::listen(BantuanStatusChanged::class, HandleBantuanStatusChange::class);
        Event::listen(LaporanStatusChanged::class, HandleLaporanStatusChange::class);
        Event::listen(DataExportRequested::class, HandleDataExportRequest::class);

        // Register policies
        \Illuminate\Support\Facades\Gate::policy(\App\Models\LaporanBantuan::class, \App\Policies\LaporanBantuanPolicy::class);
    }
}
