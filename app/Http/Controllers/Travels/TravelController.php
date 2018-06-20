<?php

namespace App\Http\Controllers\Travels;

use App\Common\Models\Blog;
use App\Common\Models\Photo;
use App\Common\Models\Travel;
use App\Common\PublicController;
use App\Common\Extensions\Code;

class TravelController extends PublicController
{
    /**
     * 展示相册页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function travels()
    {
        $data = [
            'galleries' => [],
            'propose'   => [],
        ];

        /*
         * 相册
         */
        Travel::$where     = ['state' => Code::ENABLED_STATUS];
        $data['galleries'] = Travel::getList();
        foreach ($data['galleries'] as &$gallery) {
            $gallery->cover = self::uploadImageUrl($gallery->cover);
        }

        /*
         * 站长推荐
         */
        $data['propose'] = Blog::recommendBlog();

        return $this->responseView('travels.index', $data);
    }

    /**
     * 展示照片页
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function photo(int $id)
    {
        return $this->responseView('travels.photo', [
            'id'    => $id,
            'limit' => config("siteConfig.photoLoadCount"),
        ]);
    }

    /**
     * 懒加载图片，一次展示8张（两行）
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadPhoto()
    {
        $get = self::getValidateParam(__FUNCTION__);
        /*
         * 相册中的相片
         */
        Photo::_destroy();
        Photo::$limit = $this->getPageOffset(self::limitParam());
        Photo::$where = [
            'state'    => Code::ENABLED_STATUS,
            'travelId' => (int)$get['id'],
        ];

        $data = Photo::getList();
        foreach ($data as &$photo) {
            $photo->img = self::uploadImageUrl($photo->img);
        }

        /*
         * 分页
         */
        $count = Photo::getListCount();

        self::$response['pages'] = ceil($count / Photo::$limit['limit']);

        return $this->responseJson($data);
    }
}
