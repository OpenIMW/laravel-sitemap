<?php
namespace IMW\LaravelSitemap;

use IMW\LaravelSitemap\Contracts\SitemapGenerator;

abstract class AbstractSitemapGenerator implements SitemapGenerator
{

	# Images in sitemap file
	protected $images = false;

	# Videos in sitemap file
	protected $videos = false;

	# Sitemap name
	protected $name = 'example.xml';

	/**
	 * Generate files
	 *
	 * @return void
	 */
	abstract public function generate(): void;
}

