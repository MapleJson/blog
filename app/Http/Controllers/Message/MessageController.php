<?php

namespace App\Http\Controllers\Message;

use App\Common\Models\Message;
use App\Common\PublicController;
use App\Common\Extensions\Code;

class MessageController extends PublicController
{
    /**
     * 展示留言
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function message()
    {
        /*
         * 留言列表
         */
        Message::$where = [
            'state'     => Code::ENABLED_STATUS,
            'articleId' => Code::EMPTY,
        ];
        Message::$limit = [
            'limit'  => config("siteConfig.messageCount"),
            'offset' => 0,
        ];
        /*
         * 留言排序
         */
        $message = $this->sortMessage(Message::getList()->toArray());

        return $this->responseView('message.index', compact('message'));
    }

    /**
     * 添加留言
     * @return \Illuminate\Http\JsonResponse
     */
    public function addMessage()
    {
        $post = self::getValidateParam(__FUNCTION__);

        /*
         * 去除内容两端各种奇葩空格
         */
        $post['content'] = trim(
            $post['content'],
            chr(38) . chr(110) . chr(98) .
            chr(115) . chr(112) . chr(59)
        );
        $post['content'] = trim($post['content'], "&nbsp;");
        $post['content'] = trim($post['content'], " &nbsp;");
        /*
         * 还是有空格的话。。。那就放过它吧，它也在努力着！
         */

        /*
         * 添加留言，此处默认通过审核，可以修改为审核后才展示
         * 'state'    => Code::DISABLED_STATUS
         */
        Message::$data = [
            'avatar'   => auth()->user()->avatar,
            'username' => auth()->user()->username,
            'content'  => trim($post['content']),
            'state'    => Code::ENABLED_STATUS,
        ];
        if (empty($post['articleId'])) {
            Message::$data['articleId'] = Code::EMPTY;
        } else {
            Message::$data['articleId'] = (int)trim($post['articleId']);
        }
        if (empty($post['parentId'])) {
            Message::$data['parentId'] = Code::EMPTY;
            Message::$data['targetId'] = Code::EMPTY;
        } else {
            Message::$data['parentId']   = (int)trim($post['parentId']);
            Message::$data['targetId']   = (int)trim($post['targetId']);
            Message::$data['targetUser'] = trim($post['targetUser']);
        }
        if (!Message::addToData()) {
            return $this->responseJson(Code::FAIL_TO_MESSAGE);
        }

        return $this->responseJson(Code::SUCCESS, $this->translateInfo(Code::MESSAGE_SUCCESS));

    }
}
