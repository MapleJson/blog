<?php

namespace App\Http\Controllers\Links;

use App\Common\Models\Link;
use App\Common\PublicController;
use App\Common\Extensions\Code;

class LinkController extends PublicController
{
    /**
     * 展示友情链接
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function links()
    {
        return $this->responseView('links.index');
    }

    /**
     * 添加友情链接
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyLink()
    {
        $post = self::getValidateParam(__FUNCTION__);
        /*
         * 添加友情链接，默认需要审核才展示
         */
        Link::$data = [
            'title'   => trim($post['title']),
            'logo'    => trim($post['logo']),
            'domain'  => trim($post['domain']),
            'summary' => trim($post['summary']),
        ];

        if (!Link::addToData()) {
            return $this->responseJson(Code::FAIL_TO_ADD_LINK);
        }

        return $this->responseJson(Code::SUCCESS, $this->translateInfo(Code::LINK_SUCCESS));
    }
}
