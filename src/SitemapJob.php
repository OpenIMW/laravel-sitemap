<?php
namespace IMW\LaravelSitemap;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class SitemapJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	* The number of times the job may be attempted.
	*
	* @var int
	*/
	public $tries = 2;


	 /**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(string $className = null)
	{

		if (! is_dir(config('sitemap.save_path'))) {
			mkdir(config('sitemap.save_path'), 0755, true);
		}

		if (null === $className) {

			$this->generateAll();
			return;
		}

		$this->generate($className)->updateIndex();
	}

	/**
	 * Generate all sitemaps
	 *
	 * @return void
	 */
	public function generateAll(): void
	{
		$generators = config('sitemap.generators');

		foreach ($generators as $generator)
		{
			$this->generate($generator);
		}

		$this->updateIndex();
	}

	/**
	 * Generate sitemap file
	 *
	 * @param  string $className
	 * @return SitemapJob
	 */
	public function generate(string $className): SitemapJob
	{
		$class = new $className;

		$class->generate();

		if (! $class->getMap()->saveTo(config('sitemap.save_path'))) {

			throw new SitemapException("Failed to save sitemap of: {$className}");
		}

		return $this;
	}

	/**
	 * Update sitemap index file
	 *
	 * @return void
	 */
	public function updateIndex(): void
	{
		$generators = config('sitemap.generators');
		$index = new Index();

		foreach ($generators as $generator)
		{
			$generator = new $generator;

			$index->add(
				$generator->getName(),
				date('c', filemtime(config('sitemap.save_path') .'/'. $generator->getName()))
			);
		}

		$saved = $index->saveTo(config('sitemap.save_path') .'/'. config('sitemap.index_name'));

		if ($saved === false) {

			throw new SitemapException('Failed to save sitemap of: '. config('sitemap.index_name'));
		}
	}
}
