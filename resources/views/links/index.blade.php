@extends('common/layouts')

@section('title')
    秋枫阁-友情链接
@stop

@section('breadSpan')
    故人入我梦，明我长相忆。
@stop

@section('breadN2')
    <a href="{{ route('links') }}" class="n2">友情链接</a>
@stop

@section('leftClass')linkbox @stop

@section('article')
    @if($links != '[]')
        <ul>
            @foreach($links as $link)
                <li>
                    <a href="{{ $link->domain }}" target="_blank">
                        <i>
                            <img src="{{ $link->logo }}">
                            <h3>{{ $link->title }}</h3>
                        </i>
                        <div class="linkInfo">
                            <span>{{ $link->summary }}</span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="layui-flow-more">没有更多了</div>
    @endif

    <div style="display: none" id="applyLinks">
        <form class="layui-form layui-form-pane" style="padding:20px;text-align: center;">
            @csrf
            <div class="layui-form-item">
                <label class="layui-form-label">站点名称</label>
                <div class="layui-input-block">
                    <input type="text" name="title" autocomplete="off" class="layui-input" lay-verify="required|string"
                           maxLength=50>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">logo图标</label>
                <div class="layui-input-block">
                    <input type="text" name="logo" autocomplete="off" class="layui-input" lay-verify="required|url"
                           maxLength=100>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">站点域名</label>
                <div class="layui-input-block">
                    <input type="text" name="domain" autocomplete="off" class="layui-input" lay-verify="required|url"
                           maxLength=100
                           value="http://">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">站点描述</label>
                <div class="layui-input-block">
                    <input type="text" name="summary" autocomplete="off" class="layui-input"
                           lay-verify="required|string"
                           maxLength=100>
                </div>
            </div>
            <button class="layui-btn" lay-submit="applyLink" lay-filter="applyLink">立即提交</button>
        </form>
    </div>
@stop

@section('search')
@stop

@section('cloud')
@stop

@section('aboutUs')
@stop

@section('sidebar')
    <style>
        .friendsFinks, .weixin {
            border-radius: 15px;
        }
    </style>
    <div class="friendsFinks">
        <h2 class="hometitle">申请友链</h2>
        <div class="ab_con">
            <p>
                <i class="fa fa-close"></i><span>不合法规</span>
                <i class="fa fa-close"></i><span>插边球站</span>
                <i class="fa fa-close"></i><span>红标报毒</span>
            </p>
            <p>
                <i class="fa fa-check"></i><span>原创优先</span>
            </p>
            <p>
                <button class="layui-btn layui-btn-radius layui-btn-warm apply-link">申请友链</button>
            </p>
        </div>
    </div>
@stop

@section('script')
    <script src="{{ asset('js/links.js') }}"></script>
@stop