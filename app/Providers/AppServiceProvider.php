<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Context;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Propage la locale courante aux files d'attente via Context (Laravel 13 Phase 3)
        Context::dehydrating(function ($context): void {
            $context->addHidden('locale', config('app.locale'));
        });

        Context::hydrated(function ($context): void {
            if ($context->hasHidden('locale')) {
                config(['app.locale' => $context->getHidden('locale')]);
            }
        });
    }
}
