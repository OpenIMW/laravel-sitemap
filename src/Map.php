<?php

namespace IMW\LaravelSitemap;

use SimpleXMLElement;

class Map
{
	/** @var SimpleXMLElement */
	protected $xml;

	/**
	 * Map constructor.
	 *
	 * @param string $name
	 * @param bool   $images
	 * @param bool   $videos
	 */
	public function __construct(string $name, bool $images = false, bool $videos = false)
	{
		$urlset = '<!-- GeneratedBy: imw/laravel-sitemap --><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';

		if ($images) {
			$urlset .= ' xmlns:image="'.$this->getNamespace('image').'"';
		}

		if ($videos) {
			$urlset .= ' xmlns:video="'.$this->getNamespace('video').'"';
		}

		$this->name = $name;
		$this->xml = new SimpleXMLElement(
			'<?xml version="1.0" encoding="UTF-8" ?>'.$urlset.'/>'
		);
	}

	/**
	 * Add url to map.
	 *
	 * @param string $path
	 * @param array  $options
	 *
	 * @return Map
	 */
	public function add(string $path, array $options = []): self
	{
		$url = $this->createUrl($path);

		return $this->mapUrlOptions($url, $options);
	}

	/**
	 * Save sitemap to path.
	 *
	 * @param string $path
	 *
	 * @return bool
	 */
	public function saveTo(string $path): bool
	{
		return $this->xml->asXML($path.DIRECTORY_SEPARATOR.$this->name);
	}

	/**
	 * Create new url element.
	 *
	 * @param string $path
	 *
	 * @return SimpleXMLElement
	 */
	protected function createUrl(string $path): SimpleXMLElement
	{
		$url = $this->xml->addChild('url');

		$url->addChild(
			'loc',
			$this->escUrl(config('app.url').($path[0] === '/' ? $path : "/{$path}"))
		);

		return $url;
	}

	/**
	 * Create url children.
	 *
	 * @param SimpleXMLElement $elem
	 * @param array            $options
	 * @param string           $parent
	 *
	 * @return Map
	 */
	protected function mapUrlOptions(SimpleXMLElement $elem, array $options, string $parent = null): self
	{
		foreach ($options as $k => $value) {
			if (is_array($value)) {
				$this->mapUrlOptions(
					$elem->addChild("{$k}:{$k}", null, $this->getNamespace($k)),
					$value,
					$k
				);
			} else {
				if ($k === 'lastmod') {
					// Fix date format
					$value = date('c', (is_int($value) ? $value : strtotime($value)));
				}

				$elem->addChild(($parent ? "{$parent}:{$k}" : $k), $value);
			}
		}

		return $this;
	}

	/**
	 * Get xml namespace.
	 *
	 * @param string $n
	 *
	 * @return string
	 */
	protected function getNamespace(string $n): string
	{
		switch ($n) {
			case 'image':
				return 'http://www.google.com/schemas/sitemap-image/1.1';

			case 'video':
				return 'http://www.google.com/schemas/sitemap-video/1.1';
		}

		throw new Exception("Invalid namespace: {$n}");
	}

	/**
	 * Escape url.
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	protected function escUrl(string $url): string
	{
		$url = parse_url($url);
		$url['path'] = $url['path'] ?? '';
		$url['query'] = $url['query'] ?? '';

		if ($url['path']) {
			$url['path'] = implode('/', array_map('rawurlencode', explode('/', $url['path'])));
		}

		return str_replace(
			['&', "'", '"', '>', '<'],
			['&amp;', '&apos;', '&quot;', '&gt;', '&lt;'],
			$url['scheme']."://{$url['host']}{$url['path']}".($url['query'] ? "?{$url['query']}" : '')
		);
	}
}
