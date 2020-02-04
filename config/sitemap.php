<?php

return
[

	# Path to save generated files.
	'save_path' => env('SITEMAP_PATH', false),

	# Sitemaps index filename
	'index_name' => 'index.xml',

	# Sitemaps route
	'route' => '/sitemap/{file}'
];
