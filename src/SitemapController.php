<?php

namespace IMW\LaravelSitemap;

class SitemapController
{
	/**
	 * Sitemap route action.
	 *
	 * @param string $file
	 *
	 * @return mixed
	 */
	public function sitemap($file)
	{
		$file = config('sitemap.save_path')."/{$file}";

		if (dirname(realpath($file)) !== config('sitemap.save_path')) {
			return abort(403);
		} elseif (file_exists($file) === false) {
			return abort(404);
		}

		return response(file_get_contents($file))->header('content-type', 'text/xml; charset=utf-8');
	}

	/**
	 * Robots.txt route action.
	 *
	 * @return mixed
	 */
	public function robots()
	{
		$index = str_replace('{name}', config('sitemap.index_name'), config('sitemap.route'));
		$appUrl = config('app.url');
		$agents = config('robots');
		$content = "Sitemap: {$appUrl}{$index}";

		foreach ($agents as $agent) {
			$content .= "\n\nUser-agent: {$agent['name']}\n";
			$content .= implode(PHP_EOL, $agent['rules']);
		}

		return response($content)->header('content-type', 'text/plain; charset=utf-8');
	}
}
