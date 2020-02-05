<?php

namespace IMW\LaravelSitemap;

use Illuminate\Support\ServiceProvider;

class SitemapServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		if ($this->app->runningInConsole()) {
			$this->commands([
				Commands\SitemapMakerCommand::class,
			]);
		}

		$this->publishes(
			[
			dirname(__DIR__).'/config/robots.php'  => config_path('robots.php'),
			dirname(__DIR__).'/config/sitemap.php' => config_path('sitemap.php'),
			],
			'config'
		);

		$this->loadRoutesFrom(dirname(__DIR__).'/routes.php');
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
	}
}
