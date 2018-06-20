@extends('common/layouts')

@section('title')
    相册
@stop

@section('css')
    <link rel='stylesheet' href='{{ asset('css/baguettebox.min.css') }}' type='text/css' media='all'/>
    <style>
        #baguetteBox-overlay .full-image figcaption {
            width: 80%;
            padding: 0 10%;
            white-space: normal;
            line-height: 2.3
        }
    </style>
@stop

@section('breadSpan')
    雨打梨花深闭门，忘了青春，误了青春。赏心乐事共谁论？花下销魂，月下销魂。
@stop

@section('breadN2')
    <a href="javascript:window.history.back();" class="n2">返回</a>
@stop

@section('contents')
    <div class="photo-list mt20" id="LAY_photo_load"></div>
@stop

@section('script')
    <script type='text/javascript' src="{{ asset('js/baguettebox.min.js') }}"></script>
    <script type="text/javascript">
        layui.use(['flow', 'jquery'], function () {
            var flow = layui.flow
                , $ = layui.jquery;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //按屏加载图片
            flow.load({
                elem: '#LAY_photo_load' //流加载容器
                , done: function (page, next) { //加载下一页
                    $.get(
                        '/loadPhoto'
                        , {
                            id: Number('{{ $id }}')
                            , page: page
                            , limit: Number('{{ $limit }}')
                        }
                        , function (data) {
                            var lis = [];
                            lis.push('<div id="LAY_photo_load_' + page + '">');
                            layui.each(data.data, function (index, item) {
                                lis.push('<a href="' + item.img + '" title="' + item.summary + '"><img src="' + item.img + '"></a>');
                            });
                            lis.push('</div>');
                            next(lis.join(''), page < data.pages);
                            // 相册点击效果渲染
                            baguetteBox.run("#LAY_photo_load_" + page, {
                                animation: 'fadeIn'
                            });
                        }
                        , 'json'
                    );
                }
            });
        });
    </script>
@stop