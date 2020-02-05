<?php

namespace IMW\LaravelSitemap\Contracts;

interface SitemapGenerator
{
	public function generate(): void;
}
