<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

// use Midtrans\Config as MidtransConfig;

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
         if (str_contains(request()->getHost(), 'ngrok-free.app')) {
        URL::forceScheme('https');
    }
        // Directive untuk format Rupiah
            Blade::directive('rupiah', function ($expression) {
        return "<?php echo 'Rp ' . number_format($expression, 0, ',', '.'); ?>";
    //       MidtransConfig::$serverKey = config('midtrans.server_key');
    // MidtransConfig::$clientKey = config('midtrans.client_key');
    // MidtransConfig::$isProduction = config('midtrans.is_production');
    // MidtransConfig::$isSanitized = config('midtrans.is_sanitized');
    // MidtransConfig::$is3ds = config('midtrans.is_3ds');
    });

    // Directive Angka (tanpa Rp)
    Blade::directive('angka', function ($expression) {
        return "<?php echo number_format($expression, 0, ',', '.'); ?>";
    });
    }
}
