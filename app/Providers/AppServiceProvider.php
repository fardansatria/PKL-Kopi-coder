<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class AppServiceProvider extends ServiceProvider
{
     /**
      * Register any application services.
=======
      *
      * @return void

      */
     public function register(): void
     {
          //
     }

     /**
      * Bootstrap any application services.

=======
      *
      * @return void

      */
     public function boot(): void
     {
          $this->app->booted(function () {
               $this->schedule();
          });
     }

     protected function schedule()
     {
          $schedule = $this->app->make(Schedule::class);

          $schedule->call(function () {
               $orders = \App\Models\Order::where('status', 'pending')->get();

               foreach ($orders as $order) {
                    \App\Models\Order::checkPaymentStatus($order->id);
               }
          })->everyFiveMinutes(); // Atur interval sesuai kebutuhan
     }
}
