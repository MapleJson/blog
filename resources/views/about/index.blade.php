@extends('common/layouts')

@section('title')
    关于我
@stop

@section('breadSpan')
    昨夜星辰昨夜风，画楼西畔桂堂东。身无彩凤双飞翼，心有灵犀一点通。
@stop

@section('breadN2')
    <a href="" class="n2">关于我</a>
@stop

@section('article')
    <div class="message-form mt20">
        <div class="news_infos">
            {!! $about->content or '' !!}
        </div>
    </div>
@stop

@section('search')
@stop

@section('cloud')
@stop