<?php

namespace App\Services;

use App\Common\Extensions\Code;
use App\Common\Models\Blog;
use Illuminate\Support\Facades\Cache;

class SiteMap
{
    /**
     * Return the content of the Site Map
     */
    public function getSiteMap()
    {
        if (Cache::has('site-map')) {
            return Cache::get('site-map');
        }

        $siteMap = $this->buildSiteMap();
        Cache::add('site-map', $siteMap, 120);
        return $siteMap;
    }

    /**
     * Build the Site Map
     */
    protected function buildSiteMap()
    {
        $postsInfo = $this->getPostsInfo();
        $dates     = array_values($postsInfo);
        sort($dates);
        $lastMod = last($dates);

        $url = trim(url('/'), '/') . '/';

        $xml   = [];
        $xml[] = '<?xml version="1.0" encoding="UTF-8"?' . '>';
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml[] = '  <url>';
        $xml[] = "    <loc>$url</loc>";
        $xml[] = "    <lastmod>$lastMod</lastmod>";
        $xml[] = '    <changefreq>daily</changefreq>';
        $xml[] = '    <priority>0.8</priority>';
        $xml[] = '  </url>';

        foreach ($postsInfo as $id => $lastMod) {
            $xml[] = '  <url>';
            $xml[] = "    <loc>" . route("info", $id) . "</loc>";
            $xml[] = "    <lastmod>$lastMod</lastmod>";
            $xml[] = "  </url>";
        }

        $xml[] = '</urlset>';

        return join(PHP_EOL, $xml);
    }

    /**
     * @return mixed
     */
    protected function getPostsInfo()
    {
        Blog::_destroy();
        Blog::$where = ['state' => Code::ENABLED_STATUS,];
        return Blog::getList()->pluck("created_at", "id")->toArray();
    }
}