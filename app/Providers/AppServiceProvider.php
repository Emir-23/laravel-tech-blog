<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
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
        View::composer('layouts.app', function ($view) {
            try {
                $view->with('socialLinks', SiteSetting::socialLinks());
            } catch (\Throwable) {
                $view->with('socialLinks', [
                    'linkedin_url' => null,
                    'github_url' => null,
                    'twitter_url' => null,
                ]);
            }
        });
    }
}
