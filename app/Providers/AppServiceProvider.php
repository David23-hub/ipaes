<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Events\Dispatcher;


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
    public function boot(Dispatcher $events)
    // public function boot()
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

            if (Auth::user()->role=="superuser"){
                $event->menu->add('MAIN MENU');
                $event->menu->add([
                    'text' => 'Dashboard',
                    'url'  => 'dashboard',
                    'icon' => 'fas fa-fw fa-user',
                ]);
                $event->menu->add([
                    'text' => 'Sales',
                    'icon'=> 'fas fa-user-tie',
                    'submenu'=>[
                        [
                            'text'=>'Cart',
                            'icon'=>'fas fa-shopping-cart',
                            'icon_color'=>'cyan',
                            'url'=>'viewCart',
                        ],
                        [
                            'text'=>'List Product',
                            'icon'=>'fas fa-boxes',
                            'icon_color'=>'cyan',
                            'url'=>'listProduct',
                        ],
                        [
                            'text'=>'List PO',
                            'icon'=>'fas fa-boxes',
                            'icon_color'=>'cyan',
                            'url'=>'listPO',
                        ],
                    ],
                ]);
                $event->menu->add([
                    'text' => 'Master Data',
                    'icon'    => 'fas fa-fw fa-share',
                    'submenu' => [
                        [
                            'text' => "Product",
                            'icon_color' => 'red',
                            'url' => "listItem",
                        ],
                        [
                            'text' => "Ekspedisi",
                            'icon_color' => 'red',
                            'url' => "listEkspedisi",
                        ],
                        [
                            'text' => "Dokter",
                            'icon_color' => 'red',
                            'url' => "listDokter",
                        ],
                        // [
                        //     'text' => "Category Product",
                        //     'icon_color' => 'red',
                        //     'url' => "listCategoryProduct",
                        // ],
                        [
                            'text' => "Product Bundle",
                            'icon_color' => 'red',
                            'url' => 'listProductBundle'
                        ]
                        // [
                        //     'text' => "add",
                        //     'icon_color' => 'yellow',
                        //     'url' => "#",
                        // ],
                        // [
                        //     'text' => "delete",
                        //     'icon_color' => 'red',
                        //     'url' => "#",
                        // ],
                    ]
                ]);
                $event->menu->add([
                    'text' => 'User Management',
                    'icon'    => 'fas fa-fw fa-users',
                    'submenu' => [
                        [
                            'text' => "Users",
                            'icon'    => 'fas fa-fw fa-child',
                            // 'icon_color' => 'red',
                            'url' => "listUser",
                        ],
                    ]
                ]);
                $event->menu->add([
                    'text' => 'Additional Total',
                    'icon'    => 'fas fa-fw fa-landmark',
                    'submenu' => [
                        [
                            'text' => "Salary",
                            'icon'    => 'fas fa-fw fa-wallet',
                            // 'icon_color' => 'red',
                            'url' => "listSalary",
                        ],
                        [
                            'text' => "Other Cost",
                            'icon'    => 'fas fa-fw fa-money-bill',
                            // 'icon_color' => 'red',
                            'url' => "listCost",
                        ],
                    ]
                ]);
                $event->menu->add([
                    'text' => 'Reporting',
                    'icon'    => 'fas fa-fw fa-clipboard-list',
                    'submenu' => [
                        [
                            'text' => "Sales",
                            'icon'    => 'fas fa-fw fa-user-tag',
                            'icon_color' => 'green',
                            'url' => "sales/report",
                        ],
                        [
                            'text' => "Insentive",
                            'icon'    => 'fas fa-fw fa-user-tag',
                            'icon_color' => 'green',
                            'url' => "incentive/report",
                        ],
                        [
                            'text' => "Stock",
                            'icon'    => 'fas fa-fw fa-user-tag',
                            'icon_color' => 'green',
                            'url' => "stock/report",
                        ],
                    ]
                ]);
            }else if(Auth::user()->role=="admin"){
                $event->menu->add('MAIN MENU');
                $event->menu->add([
                    'text' => 'Dashboard',
                    'url'  => 'dashboard',
                    'icon' => 'fas fa-fw fa-user',
                ]);
                $event->menu->add([
                    'text' => 'Sales',
                    'icon'=> 'fas fa-user-tie',
                    'submenu'=>[
                        
                        [
                            'text'=>'List PO',
                            'icon'=>'fas fa-boxes',
                            'icon_color'=>'cyan',
                            'url'=>'listPO',
                        ],
                    ],
                ]);
                $event->menu->add([
                    'text' => 'Master Data',
                    'icon'    => 'fas fa-fw fa-share',
                    'submenu' => [
                        [
                            'text' => "Product",
                            'icon_color' => 'red',
                            'url' => "listItem",
                        ],
                        [
                            'text' => "Ekspedisi",
                            'icon_color' => 'red',
                            'url' => "listEkspedisi",
                        ],
                        [
                            'text' => "Dokter",
                            'icon_color' => 'red',
                            'url' => "listDokter",
                        ],
                        // [
                        //     'text' => "Category Product",
                        //     'icon_color' => 'red',
                        //     'url' => "listCategoryProduct",
                        // ],
                        [
                            'text' => "Product Bundle",
                            'icon_color' => 'red',
                            'url' => 'listProductBundle'
                        ]
                        // [
                        //     'text' => "add",
                        //     'icon_color' => 'yellow',
                        //     'url' => "#",
                        // ],
                        // [
                        //     'text' => "delete",
                        //     'icon_color' => 'red',
                        //     'url' => "#",
                        // ],
                    ]
                ]);
                $event->menu->add([
                    'text' => 'User Management',
                    'icon'    => 'fas fa-fw fa-users',
                    'submenu' => [
                        [
                            'text' => "Users",
                            'icon'    => 'fas fa-fw fa-child',
                            // 'icon_color' => 'red',
                            'url' => "listUser",
                        ],
                    ]
                ]);
               
            }else if(Auth::user()->role=="manager"){
                $event->menu->add('MAIN MENU');
                $event->menu->add([
                    'text' => 'Dashboard',
                    'url'  => 'dashboard',
                    'icon' => 'fas fa-fw fa-user',
                ]);
                $event->menu->add([
                    'text' => 'Sales',
                    'icon'=> 'fas fa-user-tie',
                    'submenu'=>[
                        [
                            'text'=>'List PO',
                            'icon'=>'fas fa-boxes',
                            'icon_color'=>'cyan',
                            'url'=>'listPO',
                        ],
                    ],
                ]);
                $event->menu->add([
                    'text' => 'Master Data',
                    'icon'    => 'fas fa-fw fa-share',
                    'submenu' => [
                        [
                            'text' => "Dokter",
                            'icon_color' => 'red',
                            'url' => "listDokter",
                        ],
                    ]
                ]);
                $event->menu->add([
                    'text' => 'User Management',
                    'icon'    => 'fas fa-fw fa-users',
                    'submenu' => [
                        [
                            'text' => "Users",
                            'icon'    => 'fas fa-fw fa-child',
                            // 'icon_color' => 'red',
                            'url' => "listUser",
                        ],
                    ]
                ]);
            }else if(Auth::user()->role=="marketing"){
                $event->menu->add('MAIN MENU');
                $event->menu->add([
                    'text' => 'Dashboard',
                    'url'  => 'dashboard',
                    'icon' => 'fas fa-fw fa-user',
                ]);
                $event->menu->add([
                    'text' => 'Sales',
                    'icon'=> 'fas fa-user-tie',
                    'submenu'=>[
                        [
                            'text'=>'Cart',
                            'icon'=>'fas fa-shopping-cart',
                            'icon_color'=>'cyan',
                            'url'=>'viewCart',
                        ],
                        [
                            'text'=>'List Product',
                            'icon'=>'fas fa-boxes',
                            'icon_color'=>'cyan',
                            'url'=>'listProduct',
                        ],
                        [
                            'text'=>'List PO',
                            'icon'=>'fas fa-boxes',
                            'icon_color'=>'cyan',
                            'url'=>'listPO',
                        ],
                    ],
                ]);
                $event->menu->add([
                    'text' => 'Master Data',
                    'icon'    => 'fas fa-fw fa-share',
                    'submenu' => [
                        [
                            'text' => "Dokter",
                            'icon_color' => 'red',
                            'url' => "listDokter",
                        ],
                    ]
                ]);
                $event->menu->add([
                    'text' => 'User Management',
                    'icon'    => 'fas fa-fw fa-users',
                    'submenu' => [
                        [
                            'text' => "Users",
                            'icon'    => 'fas fa-fw fa-child',
                            // 'icon_color' => 'red',
                            'url' => "listUser",
                        ],
                    ]
                ]);
            }else if(Auth::user()->role=="finance"){
                $event->menu->add('MAIN MENU');
                $event->menu->add([
                    'text' => 'Dashboard',
                    'url'  => 'dashboard',
                    'icon' => 'fas fa-fw fa-user',
                ]);
                $event->menu->add([
                    'text' => 'User Management',
                    'icon'    => 'fas fa-fw fa-users',
                    'submenu' => [
                        [
                            'text' => "Users",
                            'icon'    => 'fas fa-fw fa-child',
                            // 'icon_color' => 'red',
                            'url' => "listUser",
                        ],
                    ]
                ]);
                $event->menu->add([
                    'text' => 'Reporting',
                    'icon'    => 'fas fa-fw fa-clipboard-list',
                    'submenu' => [
                        [
                            'text' => "Sales",
                            'icon'    => 'fas fa-fw fa-user-tag',
                            'icon_color' => 'green',
                            'url' => "sales/report",
                        ],
                        [
                            'text' => "Insentive",
                            'icon'    => 'fas fa-fw fa-user-tag',
                            'icon_color' => 'green',
                            'url' => "incentive/report",
                        ],
                        [
                            'text' => "Stock",
                            'icon'    => 'fas fa-fw fa-user-tag',
                            'icon_color' => 'green',
                            'url' => "stock/report",
                        ],
                    ]
                ]);
            }
            

        });
    }
}
