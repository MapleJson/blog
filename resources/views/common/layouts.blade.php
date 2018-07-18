<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>
        @yield('title', '秋枫阁')
    </title>
    <meta name="keywords" content="{{ $about->keywords or '个人博客,Maple,秋枫阁' }}"/>
    <meta name="description" content="{{ $about->description or '秋枫阁，是一个PHPer记录生活点滴，学习之路的个人网站。' }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(env("SECURE", false))
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="alternate" type="application/rss+xml" href="{{ url('rss') }}" title="RSS Feed">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('layui/css/layui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/m.css') }}">
    @yield('css')
</head>

<body>

<div class="bg">
    <header>
        @section('header')
            <div class="tophead">
                <div class="logo"><a href="{{ route('home') }}">{{ $about->siteName or '秋枫阁' }}</a></div>
                <div id="mnav">
                    <h2><span class="navicon"></span></h2>
                    <ul>
                        <li><a href="{{ route('home') }}">首页</a></li>
                        <li><a href="{{ route('travels') }}">点滴</a></li>
                        <li><a href="{{ route('blog') }}">博客</a></li>
                        <li><a href="{{ route('whisper') }}">耳语</a></li>
                        <li><a href="{{ route('about') }}">关于</a></li>
                        <li><a href="{{ route('message') }}">留言</a></li>
                        <li><a href="{{ route('links') }}">友链</a></li>
                        @auth
                            <li class="login-qq"><a href="{{ route('logout') }}">
                                    <img src="{{ auth()->user()->avatar }}"
                                         alt="{{ auth()->user()->username }}"></a>
                            </li>
                        @else
                            <li class="login-qq">
                                <a href="{{ route('socialiteLoginForm', 'qq') }}"><i
                                            class="fa fa-qq"></i></a>
                            </li>
                        @endauth
                    </ul>
                </div>
                <nav class="topnav" id="topnav">
                    <ul>
                        <li><a href="{{ route('home') }}">首页</a></li>
                        <li><a href="{{ route('travels') }}">点滴</a></li>
                        <li><a href="{{ route('blog') }}">博客</a></li>
                        <li><a href="{{ route('whisper') }}">耳语</a></li>
                        <li><a href="{{ route('about') }}">关于</a></li>
                        <li><a href="{{ route('message') }}">留言</a></li>
                        <li><a href="{{ route('links') }}">友链</a></li>
                        @auth
                            <li class="login-qq"><a href="{{ route('logout') }}">
                                    <img src="{{ auth()->user()->avatar }}"
                                         alt="{{ auth()->user()->username }}"></a>
                            </li>
                        @else
                            <li class="login-qq">
                                <a href="{{ route('socialiteLoginForm', 'qq') }}"><i
                                            class="fa fa-qq"></i></a>
                            </li>
                        @endauth
                    </ul>
                </nav>
            </div>
        @show
    </header>

    @yield('topPic')

    <article>
        @section('breadcrumbs')
            <h1 class="t_nav">
                <span>@yield('breadSpan')</span>
                <a href="{{ route('home') }}" class="n1">网站首页</a>
                @yield('breadN2')
            </h1>
        @show
        @section('contents')
            <div class="@yield('leftClass', 'blogs')">
                @yield('article')
            </div>
            <div class="sidebar">
                @section('search')
                    <div class="search">
                        <div class="layui-inline" style="width: 75%">
                            <input class="layui-input" placeholder="请输入关键字" name="keyboard" lay-verify="required"
                                   autocomplete="off">
                        </div>
                        <button class="layui-btn" data-type="search">搜索</button>
                    </div>
                @show
                @section('cloud')
                    @if(!empty($tags) && $tags != '[]')
                        <div class="cloud">
                            <h2 class="hometitle">标签云</h2>
                            <ul>
                                @foreach($tags as $tag)
                                    <a href="{{ route("tags", $tag->id) }}">{{ $tag->name }}</a>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @show
                @section('aboutUs')
                    <div class="aboutme">
                        <h2 class="hometitle">关于我</h2>
                        <div class="avatar">
                            <img src="{{ asset('images/avatar.jpeg') }}">
                        </div>
                        <div class="ab_con">
                            <p>网名：{{ $about->authorName }} </p>
                            <p>职业：{{ $about->profession }} </p>
                            <p>个人微信：{{ $about->weChat }} </p>
                            <p>邮箱：{{ $about->email }} </p>
                        </div>
                    </div>
                @show
                @section('sidebar')
                    @if(!empty($links) && $links != '[]')
                        <div class="links">
                            <h2 class="hometitle">友情链接</h2>
                            <ul>
                                @foreach($links as $link)
                                    <li><a target="_blank" href="{{ $link->domain }}"
                                           title="{{ $link->title }}">{{ $link->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @show
                @section('weChatQR')
                    <div class="weixin">
                        <h2 class="hometitle">个人微信</h2>
                        <ul>
                            <img src="{{ $about->weChatQR or asset('images/wx.jpeg') }}">
                        </ul>
                    </div>
                @show
            </div>
        @show
    </article>

    <div class="blank"></div>
    <footer>
        @section('footer')
            <p class="contact">
                <a href="https://github.com/MapleJson" target="_blank"><i class="fa fa-github"></i></a>
                <a href="https://wpa.qq.com/msgrd?v=3&amp;uin={{ $about->qq }}&amp;site=qq&amp;menu=yes" target="_blank"
                   title="928046320"><i class="fa fa-qq"></i></a>
                <a href="javascript:void(0)"><i class="fa fa-weixin"></i></a>
                <a href="{{ route('siteMap') }}" target="_blank"><i class="fa fa-map"></i></a>
                <a href="{{ route('rss') }}" target="_blank"><i class="fa fa-rss"></i></a>
            </p>
            <p class="copyright">支持登录方式：QQ、GitHub、微博</p>
            <p class="copyright">Copyright © 2018 by {{ $about->siteName or '秋枫阁' }}, All Rights Reserved</p>
        @show
    </footer>
</div>

<script src="{{ asset('js/nav.js') }}"></script>
<script src="{{ asset('layui/layui.js') }}"></script>
<script src="{{ asset('js/love.js') }}"></script>
<script>
    layui.use("util", function () {
        var util = layui.util;
        util.fixbar({
            bar1: "&#xe676;",
            //bar2: "&#xe677;", //微信图标
            bar2: "&#xe675;",   //新浪微博图标
            bgcolor: "#5EA51B",
            click: function (type) {
                if (type === 'bar1') {
                    window.open('https://wpa.qq.com/msgrd?v=3&uin={{ $about->qq }}&site=qq&menu=yes');
                } else if (type === 'bar2') {
                    window.open('https://service.weibo.com/share/share.php?url={{ route('home') }}&title=秋枫阁-个人网站&pic={{ asset('images/avatar.jpeg') }}&appkey=');
                }
            }
        });
    });
</script>

@yield('script')

</body>
</html>