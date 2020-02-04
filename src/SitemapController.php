<?php
namespace IMW\LaravelSitemap;

class SitemapController
{


	/**
	 * Sitemap route action
	 *
	 * @param  string $file
	 * @return mixed
	 */
	public function sitemap($file)
	{
		$file = config('sitemap.save_path') . "/{$file}";

		if (dirname(realpath($file)) !== config('sitemap.save_path')) {

			return abort(403);

		} elseif (file_exists($file) === false) {

			return abort(404);
		}

		return response(file_get_contents($file))->header('content-type', 'text/xml; charset=utf-8');
	}

	/**
	 * Robots.txt route action
	 *
	 * @return mixed
	 */
	public function robots()
	{

	}
}
