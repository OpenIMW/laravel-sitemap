<?php
namespace IMW\LaravelSitemap;

use SimpleXMLElement;

class Index
{

	protected $xml;

	public function __construct()
	{
		$this->xml = new SimpleXMLElement(
			'<?xml version="1.0" encoding="UTF-8" ?><!-- GeneratedBy: imw/laravel-sitemap --><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>'
		);
	}

	public function add(string $name, string $lastmod): Index
	{
		$sitemap = $this->xml->addChild('sitemap');
		$sitemap->addChild('loc',
			config('app.url') . str_replace('{name}', $name, config('sitemap.route'))
		);
		$sitemap->addChild('lastmod', $lastmod);

		return $this;
	}

	public function saveTo(string $path): bool
	{
		return $this->xml->asXML($path);
	}

}
