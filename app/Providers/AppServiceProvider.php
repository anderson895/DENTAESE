<?php

namespace App\Providers;

use App\Services\AndroidSmsGateway;
use App\Services\SemaphoreSms;
use App\Services\SmsGateway;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Pinipili ng SMS_DRIVER sa .env kung aling gateway ang gagamitin.
        $this->app->bind(SmsGateway::class, fn () => match (config('services.sms.driver')) {
            'android' => new AndroidSmsGateway(),
            default   => new SemaphoreSms(),
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
