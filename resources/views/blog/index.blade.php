@extends('common/layouts')

@section('title')
    个人博客
@stop

@section('breadSpan')
    自小刺头深草里，而今渐觉出蓬蒿。时人不识凌云木，直待凌云始道高。
@stop

@section('breadN2')
    <a href="{{ route("blog") }}" class="n2">个人博客</a>
@stop

@section('article')
    <div class="mt20"></div>
    <ul id="LAY_blog_load">
        @if(!empty($blogs))
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
                        <a href="{{ route("info", $blog->id) }}">
                            <span class="text-blue">@if($blog->original === 1)【原创】@else
                                    【转载】@endif</span>{{ $blog->title }}
                        </a>
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
        @endif
    </ul>
@stop

@section('aboutUs')
@stop

@section('sidebar')
    @if(!empty($propose) && $propose != '[]')
        <div class="paihang">
            <h2 class="hometitle">站长推荐</h2>
            <ul>
                @foreach($propose as $prop)
                    <li>
                        <b>
                            <a href="{{ route("info", $prop->id) }}" target="_blank">
                                <span class="text-blue">@if($prop->original === 1)【原创】@else
                                        【转载】@endif</span>{{ $prop->title }}
                            </a>
                        </b>
                        <p><i><img src="{{ $prop->img }}"></i><span>{{ $prop->summary }}</span></p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @parent
@stop

@section('script')
    @if(empty($noFlow))
        <script type='text/javascript' src="{{ asset('js/blog.js') }}"></script>
    @endif
@stop
