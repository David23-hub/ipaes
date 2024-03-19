<?php

namespace App\Providers;

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
    // public function boot(Dispatcher $events)
    public function boot()
    {
        // $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

            // if (Auth::user()->role=="admin"){
            //     $event->menu->add(' ');
            //     $event->menu->add('ADMIN MENU');
            //     $event->menu->add([
            //         'text' => 'Blog',
            //         'icon_color' => 'red',
            //         'url' => 'dashboard',
            //     ]);
            // }

        // });
    }
}
