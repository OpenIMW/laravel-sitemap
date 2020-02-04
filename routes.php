<?php

Route::get('/robots.txt', '\IMW\LaravelSitemap\SitemapController@robots');

Route::get(config('sitemap.route'), 'IMW\LaravelSitemap\SitemapController@sitemap');
