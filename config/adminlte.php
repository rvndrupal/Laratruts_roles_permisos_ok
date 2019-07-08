<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Recursos',

    'title_prefix' => 'Recursos - ',

    'title_postfix' => 'Admin',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Recursos</b>ADMIN',

    'logo_mini' => '<b>P</b>OS',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'green-light',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'Sistema de Administración',
        [
            'text' => 'Gráficas',
            'url'  => 'admin/charts',
            'permission'  => 'read-charts',
            'icon' => 'fas fa-chart-line'
        ],

        [
            'text' => 'Usuarios',
            'url'  => 'admin/user',
            'icon' => 'users',
            'submenu' => [
                [
                    'text' => 'Listado',
                    'url'  => 'admin/user',
                    'permission'  => 'read-customers',
                    'icon' => 'list'
                ],
                [
                    'text' => 'Crear',
                    'url'  => 'admin/user/create',
                    'permission'  => 'create-customers',
                    'icon' => 'plus-circle'
                ],
            ],
        ],


        [
            'text' => 'Clientes',
            'url'  => 'admin/customers',
            'icon' => 'users',
            'submenu' => [
                [
                    'text' => 'Listado',
                    'url'  => 'admin/customers',
                    'permission'  => 'read-customers',
                    'icon' => 'list'
                ],
                [
                    'text' => 'Crear',
                    'url'  => 'admin/customers/create',
                    'permission'  => 'create-customers',
                    'icon' => 'plus-circle'
                ],
            ],
        ],
        [
            'text' => 'Métodos de pago',
            'url'  => 'admin/payment-methods',
            'icon' => 'gem',
            'submenu' => [
                [
                    'text' => 'Listado',
                    'url'  => 'admin/payment-methods',
                    'permission'  => 'read-payment-methods',
                    'icon' => 'list'
                ],
                [
                    'text' => 'Crear',
                    'url'  => 'admin/payment-methods/create',
                    'permission'  => 'create-payment-methods',
                    'icon' => 'plus-circle'
                ],
            ],
        ],
        [
            'text' => 'Pedidos',
            'url'  => 'admin/orders',
            'icon' => 'shopping-basket',
            'submenu' => [
                [
                    'text' => 'Listado',
                    'url'  => 'admin/orders',
                    'permission'  => 'read-orders',
                    'icon' => 'list'
                ],
                [
                    'text' => 'Crear',
                    'url'  => 'admin/orders/create',
                    'permission'  => 'create-orders',
                    'icon' => 'plus-circle'
                ],
            ],
        ],
        [
            'text' => 'Productos',
            'url'  => 'admin/products',
            'icon' => 'boxes',
            'submenu' => [
                [
                    'text' => 'Listado',
                    'url'  => 'admin/products',
                    'permission'  => 'read-products',
                    'icon' => 'list'
                ],
                [
                    'text' => 'Crear',
                    'url'  => 'admin/products/create',
                    'permission'  => 'create-products',
                    'icon' => 'plus-circle'
                ],
            ],
        ],
        [
            'text' => 'Categorías',
            'url'  => 'admin/categories',
            'icon' => 'tag',
            'submenu' => [
                [
                    'text' => 'Listado',
                    'url'  => 'admin/categories',
                    'permission'  => 'read-categories',
                    'icon' => 'list'
                ],
                [
                    'text' => 'Crear',
                    'url'  => 'admin/categories/create',
                    'permission'  => 'create-categories',
                    'icon' => 'plus-circle'
                ],
            ],
        ],
        [
            'text' => 'Etiquetas',
            'url'  => 'admin/tags',
            'icon' => 'tags',
            'submenu' => [
                [
                    'text' => 'Listado',
                    'url'  => 'admin/tags',
                    'permission'  => 'read-tags',
                    'icon' => 'list'
                ],
                [
                    'text' => 'Crear',
                    'url'  => 'admin/tags/create',
                    'permission'  => 'create-tags',
                    'icon' => 'plus-circle'
                ],
            ],
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        \App\Filters\MenuFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
