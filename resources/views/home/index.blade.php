@extends('common/layouts')

@section('topPic')
    <div class="picshow">
        <ul>
            @foreach($topPic as $pic)
                <li style="width: {{ 100/count($topPic) }}%;" class="layui-anim" data-anim="layui-anim-fadein">
                    <a href="{{ route('home') }}"><i><img src="{{ $pic->img }}"></i>
                        <div class="font">
                            <h3>{{ $pic->title }}</h3>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@stop

@section('breadcrumbs')
@stop

@section('contents')
    @if(!empty($banners))
        <div class="layui-carousel" id="banner">
            <div carousel-item="">
                @foreach($banners as $key => $banner)
                    <div><img src="{{ $banner->img }}" alt="{{ $banner->title }}"></div>
                @endforeach
            </div>
        </div>
    @endif
    @parent
@stop

@section('article')
    @if($blogs != '[]')
        @foreach($blogs as $blog)
            <li class="layui-anim" data-anim="layui-anim-fadein">
                @if(!empty($blog->img))
                    <span class="blogpic">
                    <a href="{{ route("info", $blog->id) }}">
                        <img src="{{ $blog->img }}">
                    </a>
                </span>
                @endif
                <h3 class="blogtitle">
                    <a href="{{ route("info", $blog->id) }}">{{ $blog->title }}</a>
                </h3>
                <div class="bloginfo">
                    <p>{{ $blog->summary }}</p>
                </div>
                <div class="autor">
                    <span class="lm">
                        @foreach($blog->tags as $tag)
                            <i title="{{ $tag->name }}" class="layui-badge">{{ $tag->name }}</i>
                        @endforeach
                    </span>
                    <span class="dtime">{{ $blog->created_at }}</span>
                    <span class="read"><i class="fa fa-eye"></i> {{ $blog->read }}</span>
                    <span class="comments"><i class="fa fa-comments"></i> {{ $blog->comments }}</span>
                    <span class="readmore"><a href="{{ route("info", $blog->id) }}">阅读原文</a></span>
                </div>
            </li>
        @endforeach
    @else
        <div class="layui-flow-more">此主人很懒,什么都没有留下</div>
    @endif
@stop

@section('search')
@stop

@section('cloud')
@stop

@section('aboutUs')
    <div class="about">
        <div class="avatar"><img src="{{ asset('images/avatar.jpeg') }}" alt=""></div>
        <p class="abname">{{ $about->authorName }}</p>
        <p class="abposition">{{ $about->profession }}</p>
        <div class="abtext">{{ $about->mood or '一个90后草根程序猿！2015年入行。一直潜心研究web后端技术，一边工作一边积累经验，分享一些个人笔记，以及开发经验等心得。' }}</div>
    </div>
@stop

@section('sidebar')
@stop

@section('script')
    <script>
        layui.use(['carousel', 'jquery'], function () {
            var carousel = layui.carousel
                , $ = layui.$;
            //图片轮播
            carousel.render({
                elem: '#banner'
                , width: '100%'
                , height: '680px'
                , interval: 5000
            });

            $(".blogs .layui-anim").addClass("layui-anim-scaleSpring");
            $(".picshow .layui-anim").addClass("layui-anim-rotate");
        });
    </script>
@stop