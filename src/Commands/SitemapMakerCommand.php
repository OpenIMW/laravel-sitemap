<?php
namespace IMW\LaravelSitemap\Commands;

use Illuminate\Console\Command;

class SitemapMakerCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'make:sitemap {name?}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a sitemap generator class.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$name = $this->argument('name');

		if (! $name) {

			$this->error("Sitemap class name required!");
			exit(1);
		}

		$class = app_path("Sitemap/{$name}.php");

		if (file_exists($class)) {

			$this->error("{$class} already exists!");
			exit(2);

		} elseif (! is_dir(app_path("Sitemap"))) {

			mkdir(app_path('Sitemap'));
		}

		$bytes = file_put_contents(
			$class,
			str_replace('{name}', $name, file_get_contents(dirname(__DIR__, 2) . '/stubs/sitemap.stub'))
		);

		if (! $bytes) {

			$this->error("Cannot create file: {$class}");
			exit(3);
		}
	}
}
