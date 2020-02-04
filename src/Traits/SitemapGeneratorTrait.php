<?php

namespace IMW\LaravelSitemap\Traits;

use IMW\LaravelSitemap\Map;

trait SitemapGeneratorTrait
{
    // Images in sitemap file
    protected $images = false;

    // Videos in sitemap file
    protected $videos = false;

    // Sitemap name
    protected $name = 'example.xml';

    /** @var Map */
    protected $map;

    protected function initSitemap()
    {
        $this->map = new Map($this->name, $this->images, $this->videos);
    }

    /**
     * Get map object.
     *
     * @return Map
     */
    public function getMap(): Map
    {
        return $this->map;
    }

    /**
     * Get sitemap name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
