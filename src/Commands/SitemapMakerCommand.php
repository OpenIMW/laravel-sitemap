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
    protected $signature = 'make:sitemap {name}';

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

    }
}
