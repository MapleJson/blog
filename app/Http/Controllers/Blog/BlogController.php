<?php

namespace App\Http\Controllers\Blog;

use App\Common\Models\Blog;
use App\Common\Models\Message;
use App\Common\Models\Tag;
use App\Common\PublicController;
use App\Common\Extensions\Code;

class BlogController extends PublicController
{
    /**
     * 博客文章列表页展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blog()
    {
        $data = [];

        /*
         * 站长推荐
         */
        $data['propose'] = Blog::recommendBlog();
        /*
         * 标签
         */
        $data['tags'] = $this->getTags();

        return $this->responseView('blog.index', $data);
    }

    /**
     * 懒加载文章列表，一次加载 5 篇文章
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadBlog()
    {
        /*
         * 文章列表
         */
        Blog::_destroy();
        Blog::$limit = $this->getPageOffset(self::limitParam());
        Blog::$where = ['state' => Code::ENABLED_STATUS];

        $blog = Blog::getList();
        $data = $blog->toArray();
        foreach ($blog as $key => $item) {
            $data[$key]['img'] = self::uploadImageUrl($item->img);
            foreach ($item->tags as $tag) {
                $data[$key]['tags'][] = $tag->name;
            }
        }
        /*
         * 分页
         */
        $count = Blog::getListCount();

        self::$response['pages'] = ceil($count / Blog::$limit['limit']);

        return $this->responseJson($data);
    }

    /**
     * 根据标签ID查找文章
     * @param int $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blogByTag(int $tag)
    {
        $data = [
            'noFlow' => true,
            'blogs'  => [],
        ];
        /*
         * 标签
         */
        Tag::$pivot   = ['tag_id' => $tag];
        $data['tags'] = $this->getTags();

        foreach ($data['tags'] as $tag) {
            foreach ($tag->blog as $item) {
                $item->img = self::uploadImageUrl($item->img);
                $data['blogs'][] = $item;
            }
        }
        /*
         * 站长推荐
         */
        $data['propose'] = Blog::recommendBlog();

        return $this->responseView('blog.index', $data);
    }

    /**
     * 展示文章内容
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info(int $id)
    {
        $data = [
            'pre'     => [],
            'next'    => [],
            'message' => [],
            'related' => [], // 相关文章，暂未做
            'propose' => [],
        ];
        /*
         * 文章内容
         */
        Blog::_destroy();
        $data['info'] = Blog::getOne($id);
        $data['info']->read += Code::YES;
        $data['info']->save();
        /*
         * 上一篇
         */
        if ($pre = Blog::getPrevArticleId($id)) {
            $data['pre'] = Blog::getOne($pre);
        }
        /*
         * 下一篇
         */
        if ($next = Blog::getNextArticleId($id)) {
            $data['next'] = Blog::getOne($next);
        }

        /*
         * 标签
         */
        $data['tags'] = $this->getTags();

        /*
         * 文章留言
         */
        Message::$where['articleId'] = $id;

        Message::$limit = [
            'limit'  => config("siteConfig.messageCount"),
            'offset' => 0,
        ];

        $data['message'] = $this->sortMessage(Message::getList()->toArray());

        /*
         * 站长推荐
         */
        $data['propose'] = Blog::recommendBlog();

        return $this->responseView('blog.info', $data);
    }

    /**
     * 获取标签列表
     * @return mixed
     */
    private function getTags()
    {
        Tag::$where = ['state' => Code::ENABLED_STATUS];
        $tags       = Tag::getList();
        Tag::_destroy();
        return $tags;
    }
}
