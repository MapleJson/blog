<?php

namespace App\Http\Controllers\Search;

use App\Common\Models\Blog;
use App\Common\PublicController;
use App\Common\Extensions\Code;

class SearchController extends PublicController
{
    /**
     * 搜索功能
     * @return \Illuminate\Http\JsonResponse
     */
    public function search()
    {
        $post = self::getValidateParam(__FUNCTION__);

        $post['keyboard'] = trim($post['keyboard']);
        /*
         * 搜索标题与搜索内容有关的文章，可添加简介和文章内容模糊搜索
         */
        Blog::$where = [
            ['state', '=', Code::ENABLED_STATUS],
            ['title', 'like', "%{$post['keyboard']}%"],
        ];

        $blog = Blog::getList();

        $data = [];
        foreach ($blog as $key => $item) {
            $data[$key] = [
                'id'    => (int)$item->id,
                'title' => $item->title,
            ];
        }

        return $this->responseJson($data);
    }
}
