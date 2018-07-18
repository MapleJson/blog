@extends('common/layouts')

@section('title')
    秋枫阁-中国博客联盟
@stop

@section('breadSpan')
    昨夜星辰昨夜风，画楼西畔桂堂东。身无彩凤双飞翼，心有灵犀一点通。
@stop

@section('breadN2')
    <a href="{{ route('about') }}" class="n2">关于我</a>
    <a href="{{ route('hutui') }}" class="n1">中国博客联盟</a>
@stop

@section('article')
    <div class="message-form mt20">
        <script language="javascript" src="https://zgboke.org/hutui.js"></script>
    </div>
@stop

@section('search')
@stop

@section('cloud')
@stop