<?php

namespace App\Services;

use App\Common\Extensions\Code;
use App\Common\Models\Blog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class RssFeed
{
    /**
     * Return the content of the RSS feed
     */
    public function getRSS()
    {
        if (Cache::has('rss-feed')) {
            return Cache::get('rss-feed');
        }

        $rss = $this->buildRssData();
        Cache::add('rss-feed', $rss, 120);

        return $rss;
    }

    /**
     * Return a string with the feed data
     *
     * @return string
     */
    protected function buildRssData()
    {
        $now     = Carbon::now();
        $feed    = new Feed();
        $channel = new Channel();
        $channel->title(config('siteConfig.siteName'))
            ->description(config('siteConfig.description'))
            ->url(url('/'))
            ->language('en')
            ->copyright('Copyright (c) ' . config('siteConfig.authorName'))
            ->lastBuildDate($now->timestamp)
            ->appendTo($feed);

        $posts = Blog::where('created_at', '<=', $now)
            ->where('state', Code::ENABLED_STATUS)
            ->orderBy('created_at', 'desc')
            ->take(config('siteConfig.rssSize'))
            ->get();
        foreach ($posts as $post) {
            $item = new Item();
            $item->title($post->title)
                ->description($post->summary)
                ->url(route("info", $post->id))
                ->pubDate($post->created_at->timestamp)
                ->guid(route("info", $post->id), true)
                ->appendTo($channel);
        }

        $feed = (string)$feed->render();

        // Replace a couple items to make the feed more compliant
        $feed = str_replace(
            '<rss version="2.0">',
            '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">',
            $feed
        );
        $feed = str_replace(
            '<channel>',
            '<channel>' . PHP_EOL . '    <atom:link href="' . route('rss') .
            '" rel="self" type="application/rss+xml" />',
            $feed
        );

        return $feed;
    }
}