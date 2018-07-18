<?php

namespace App\Common\Extensions;

trait RequestRule
{
    // 公共参数
    public $pageLimitRule = [
        'page'       => 'required_unless:selectType,2|integer|min:1',
        'limit'      => 'required_unless:selectType,2|integer|between:1,50',
        'selectType' => "nullable|integer|between:1,2",
    ];

    public $addMessageRule = [
        'articleId'  => 'nullable|integer|min:1',
        'content'    => 'required|string',
        'targetUser' => 'nullable|string',
        'parentId'   => 'required_with:targetUser|integer|min:1',
        'targetId'   => 'required_with:targetUser|integer|min:1',
    ];

    public $applyLinkRule = [
        'title'   => 'required|string',
        'logo'    => 'required|url',
        'domain'  => 'required|url',
        'summary' => 'required|string',
    ];

    public $loadPhotoRule = [
        'id' => 'required|integer|min:1',
    ];
}