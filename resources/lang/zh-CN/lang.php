<?php

use App\Common\Extensions\Code;

return [
    'manageImages'  => "图片管理",
    'thumbnail'     => "缩略图",
    'uploadImage'   => "图片上传",
    'synopsis'      => "概要",
    'administrator' => "超级管理员",
    'isShow'        => '是否展示',
    'posts'         => "文章",
    'tags'          => "标签",
    'author'        => "作者",
    'release'       => "发布",
    'read'          => "阅读量",
    'comments'      => "留言数",
    'contents'      => "内容",
    'cover'         => "封面图",
    'top'           => "置顶",
    'recommend'     => "推荐",
    'discuss'       => "评论",
    'commentUser'   => "回复人",
    'targetUser'    => "被回复人",
    'domain'        => "链接",

    'states' => [
        'on'  => [
            'value' => 1,
            'text'  => '是',
            'color' => 'success'
        ],
        'off' => [
            'value' => 2,
            'text'  => '否',
            'color' => 'danger'
        ],
    ],

    'yesNo'             => [
        Code::YES => "是",
        Code::NO  => "否",
    ],
    'successfulFailure' => [
        Code::IS_SUCCESSFUL => "成功",
        Code::IS_FAILURE    => "失败",
    ],

];