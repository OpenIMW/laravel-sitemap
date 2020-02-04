<?php

return
[

    // Path to save generated files.
    'save_path' => env('SITEMAP_PATH', storage_path('sitemaps')),

    // Sitemaps index filename
    'index_name' => 'index.xml',

    // Sitemaps route
    'route' => '/sitemap/{name}',

    // Enabled Generators
    'generators' => [
        // App\Sitemap\Example::class
    ],
];
