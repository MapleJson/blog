<?php

namespace App\Http\Controllers\Whisper;

use App\Common\Models\Blog;
use App\Common\Models\Whisper;
use App\Common\PublicController;
use App\Common\Extensions\Code;

class WhisperController extends PublicController
{
    /**
     * 耳语列表页展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function whisper()
    {
        $propose = Blog::recommendBlog();

        return $this->responseView('whisper.index', compact('propose'));
    }

    /**
     * 懒加载文章列表，一次加载 5 篇文章
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadWhisper()
    {
        /*
         * 文章列表
         */
        Whisper::_destroy();
        Whisper::$limit = $this->getPageOffset(self::limitParam());
        Whisper::$where = ['state' => Code::ENABLED_STATUS];

        $data = Whisper::getList()->toArray();
        foreach ($data as &$item) {
            $item['created_at'] = date("Y年m月d", strtotime((string)$item['created_at']));
        }

        /*
         * 分页
         */
        $count = Whisper::getListCount();

        self::$response['pages'] = ceil($count / Whisper::$limit['limit']);

        return $this->responseJson($data);
    }
}
