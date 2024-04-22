<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('formattedDate', function ($date) {
            return "<?php echo ($date)->format('d/m/Y') ?>";
        });

        Blade::directive('formattedDateTime', function ($date) {
            return "<?php echo ($date)->format('d/m/Y h:i a') ?>";
        });
        Blade::directive('formattedTime', function ($date) {
            return "<?php echo ($date)->format('h:i') ?>";
        });


        Blade::directive('formattedPrice', function ($price) {
            return "<?php echo strval(number_format($price / 100, 2, ',', '.')) ?>";
        });

        Paginator::useBootstrap();
    }
}
