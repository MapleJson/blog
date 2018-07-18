<?php

namespace App\Http\Controllers\Home;

use App\Common\Models\Blog;
use App\Common\Models\Carousel;
use App\Common\PublicController;
use App\Common\Extensions\Code;
use App\Services\RssFeed;
use App\Services\SiteMap;

class HomeController extends PublicController
{
    /**
     * 首页展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /*
         * 首页顶部图片和轮播
         */
        Carousel::$where = ['state' => Code::ENABLED_STATUS];
        $carousels       = Carousel::getList();
        $data            = [
            'topPic'  => [],
            'banners' => [],
        ];
        foreach ($carousels as $carousel) {
            $carousel->img = self::uploadImageUrl($carousel->img);
            if ($carousel->type === Code::TOP_PIC_TYPE) {
                if (count($data['topPic']) <= config("siteConfig.topPicCount")) {
                    $data['topPic'][] = $carousel;
                }
            } elseif ($carousel->type === Code::CAROUSEL_TYPE) {
                if (count($data['banners']) <= config("siteConfig.bannersCount")) {
                    $data['banners'][] = $carousel;
                }
            }
        }
        /*
         * 首页文章列表
         */
        Blog::$limit   = [
            'limit'  => config("siteConfig.blogShowCount"),
            'offset' => 0,
        ];
        $data['blogs'] = Blog::getList();
        Blog::_destroy();
        foreach ($data['blogs'] as &$blog) {
            $blog->img = self::uploadImageUrl($blog->img);
        }

        return $this->responseView('home.index', $data);
    }

    /**
     * 订阅
     *
     * @param RssFeed $feed
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function rss(RssFeed $feed)
    {
        $rss = $feed->getRSS();

        return response($rss, 200, [
            'Content-type' => 'application/rss+xml'
        ]);
    }

    public function siteMap(SiteMap $siteMap)
    {
        $map = $siteMap->getSiteMap();

        return response($map, 200, ['Content-type' => 'text/xml']);
    }
}
