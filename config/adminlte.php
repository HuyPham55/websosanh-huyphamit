<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'AdminLTE 3',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => env('APP_NAME'),
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'AdminLTE',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 150,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'admin/dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'Search',
        ],
        [
            'text' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'fa fa-fw fa-tachometer-alt',
        ],
        ['header' =>    'content'],
        [
            'text' => 'homepage',
            'icon' => 'fa fa-fw fa-home',
            'can' => ['show_list_home_slides', 'show_list_footer_slides'],
            'submenu' => [
                [
                    'text' => 'slides',
                    'route' => 'home_slides.list',
                    'icon' => 'far fa-fw',
                    'active' => ['admin/home-slides/*'],
                    'can' => 'show_list_home_slides'
                ],
                [
                    'text' => 'Footer slide',
                    'route' => 'footer_slides.list',
                    'icon' => 'far fa-fw',
                    'active' => ['admin/footer-slides/*'],
                    'can' => 'show_list_footer_slides'
                ],
            ],
        ],
        [
            'text' => 'Sellers',
            'icon' => 'fas fa-fw fa-store',
            'can' => ['show_list_sellers'],
            'submenu' => [
                [
                    'text' => 'Sellers',
                    'route' => 'sellers.list',
                    'icon' => 'far fa-fw fa-store',
                    'can' => 'show_list_sellers',
                    'active' => ['admin/sellers/*'],
                ],
            ],
        ],
        [
            'text' => 'Products',
            'icon' => 'fas fa-fw fa-barcode',
            'can' => ['show_list_product_categories', 'show_list_products'],
            'submenu' => [
                [
                    'text' => 'Categories',
                    'route' => 'product_categories.list',
                    'icon' => 'far fa-fw',
                    'active' => ['admin/products/categories/*'],
                    'can' => 'show_list_product_categories'
                ],
                [
                    'text'    => 'Products',
                    'route'     => 'products.list',
                    'icon' => 'far fa-fw',
                    'active' => ['admin/products/items/*'],
                    'can' => 'show_list_products'
                ],
                [
                    'text' => 'Scrapes',
                    'route' => 'scrapes.list',
                    'icon' => 'far fa-fw',
                    'active' => ['admin/products/scrapes/*'],
                    'can' => 'show_list_scrapes'
                ],
                [
                    'text' => 'Comparisons',
                    'route' => 'comparisons.list',
                    'icon' => 'far fa-fw',
                    'active' => ['admin/products/comparisons/*'],
                    'can' => 'show_list_comparisons'
                ]
            ],
        ],
        [
            'text' => 'blog',
            'icon' => 'fas fa-fw fa-rss',
            'can' => ['show_list_blog_categories', 'show_list_blog_posts'],
            'submenu' => [
                [
                    'text' => 'Categories',
                    'route' => 'blog_categories.list',
                    'icon' => 'far fa-fw',
                    'active' => ['admin/blog/categories/*'],
                    'can' => 'show_list_blog_categories'
                ],
                [
                    'text'    => 'Posts',
                    'route'     => 'blog_posts.list',
                    'icon' => 'far fa-fw',
                    'active' => ['admin/blog/posts/*'],
                    'can' => 'show_list_blog_posts'
                ]
            ],
        ],
        [
            'text' => 'static_pages',
            'icon' => 'far fa-fw fa-file',
            'can' => ['update_home_page', 'update_about_page', 'update_blog_index', 'update_404_page'],
            'submenu' => [
                [
                    'text' => 'homepage',
                    'route' => ['backend.static_page', ['key' => 'home_page', 'title' => 'label.home_page']],
                    'icon' => 'far fa-fw',
                    'active' => ['admin/static-pages/home_page*'],
                    'can' => 'update_home_page'
                ],
                [
                    'text' => 'about_page',
                    'route' => ['backend.static_page', ['key' => 'about_page', 'title' => 'label.home_page']],
                    'icon' => 'far fa-fw',
                    'active' => ['admin/static-pages/about_page*'],
                    'can' => 'update_about_page'
                ],
                [
                    'text' => 'blog',
                    'route' => ['backend.static_page', ['key' => 'blog_index', 'title' => 'label.home_page']],
                    'icon' => 'far fa-fw',
                    'active' => ['admin/static-pages/blog_index*'],
                    'can' => 'update_blog_index'
                ],
            ],
        ],
        [
            'text' => 'faqs',
            'route' => 'faqs.list',
            'icon' => 'fas fa-fw fa-question-circle',
            'can' => ['show_list_faqs'],
            'active' => ['admin/faqs/*'],
        ],
        [
            'text' => 'contact_requests',
            'route' => 'contacts.list',
            'icon' => 'fas fa-fw fa-address-card',
            'can' => ['show_list_contacts'],
            'active' => ['admin/contacts/*'],
        ],
        ['header' => 'website_settings'],
        [
            'text' => 'banners',
            'route' => 'settings.banner',
            'icon' => 'fas fa-fw fa-image',
            'can' => 'change_banners'
        ],
        [
            'text' => 'settings',
            'route' => 'settings.options',
            'icon' => 'fas fa-fw fa-cogs',
            'can' => 'change_website_settings'
        ],
        ['header' => 'account_settings'],
        [
            'text' => 'profile',
            'route' => 'users.edit_profile',
            'icon' => 'fas fa-fw fa-user',
        ],
        [
            'text' => 'change_password',
            'route' => 'users.change_password',
            'icon' => 'fas fa-fw fa-lock',
        ],
        ['header' => 'accounts_and_permissions'],
        [
            'text' => 'users',
            'route' => 'users.list',
            'icon' => 'fas fa-fw fa-users',
            'can' => 'show_list_users',
            'active' => ['admin/users/*']
        ],
        [
            'text' => 'roles',
            'route' => 'roles.list',
            'icon' => 'fas fa-fw fa-shield-alt',
            'can' => 'show_list_roles',
            'active' => ['admin/role/*']
        ],
        [
            'text' => 'members',
            'route' => 'members.list',
            'icon' => 'fas fa-fw fa-users',
            'can' => 'show_list_members',
            'active' => ['admin/members/*']
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'bootstrapSwitch' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '/vendor/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/vendor/bootstrap-switch/js/bootstrap-switch.min.js',
                ],
            ],
        ],
        'toastr' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '/vendor/toastr/toastr.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/vendor/toastr/toastr.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
