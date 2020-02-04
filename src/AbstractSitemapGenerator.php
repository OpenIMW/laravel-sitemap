<?php
namespace IMW\LaravelSitemap;

use IMW\LaravelSitemap\Contracts\SitemapGenerator;

abstract class AbstractSitemapGenerator implements SitemapGenerator
{
	use Traits\SitemapGeneratorTrait;

	final public function __construct()
	{
		$this->initSitemap();
	}

	/**
	 * Generate files
	 *
	 * @return void
	 */
	abstract public function generate(): void;
}
