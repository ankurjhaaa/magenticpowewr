<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        $this->configureDefaults();

        \Illuminate\Support\Facades\View::composer('layouts.public', function ($view) {
            $sidebarCategories = \App\Models\Category::active()
                ->ordered()
                ->with(['products' => function($q) {
                    $q->active()->orderBy('name');
                }])
                ->get();
            $view->with('sidebarCategories', $sidebarCategories);

            // Fetch global settings
            $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
            $view->with('siteSettings', $settings);
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
