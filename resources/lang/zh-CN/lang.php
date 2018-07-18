<?php

use App\Common\Extensions\Code;

return [
    'manageImages'    => "图片管理",
    'thumbnail'       => "缩略图",
    'uploadImage'     => "图片上传",
    'uploadSucceeded' => "上传成功",
    'synopsis'        => "概要",
    'administrator'   => "超级管理员",
    'isShow'          => '是否展示',
    'posts'           => "文章",
    'tags'            => "标签",
    'author'          => "作者",
    'release'         => "发布",
    'read'            => "阅读量",
    'comments'        => "留言数",
    'contents'        => "内容",
    'cover'           => "封面图",
    'top'             => "置顶",
    'recommend'       => "推荐",
    'discuss'         => "评论",
    'commentUser'     => "回复人",
    'targetUser'      => "被回复人",
    'links'           => "友情链接",
    'domain'          => "链接",
    'about'           => "关于我",
    'siteName'        => "站点名称",
    'profession'      => "职业",
    'keywords'        => "关键字",
    'description'     => "说明",
    'mood'            => "描述",
    'weChat'          => "微信账号",
    'weChatQR'        => "微信二维码",
    'qq'              => "QQ号",
    'carousels'       => "首页图片",
    'type'            => "类型",
    'messages'        => "留言",
    'travels'         => "相册",
    'photos'          => "相片",
    'frontUser'       => "用户",
    'githubName'      => "GitHub名称",
    'githubUrl'       => "GitHub地址",
    'isUse'           => "启用",
    'nickname'        => "昵称",
    'whisper'         => "耳语",
    'original'        => "原创",

    'states' => [
        'on'  => [
            'value' => Code::YES,
            'text'  => '是',
            'color' => 'success'
        ],
        'off' => [
            'value' => Code::NO,
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

    'carouselType' => [
        Code::TOP_PIC_TYPE  => '顶部',
        Code::CAROUSEL_TYPE => '轮播',
    ],

];