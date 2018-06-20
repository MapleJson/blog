@extends('common/layouts')

@section('title')
    留言
@stop

@section('breadSpan')
    花开不并百花丛，独立疏篱趣未穷。宁可枝头抱香死，何曾吹落北风中。
@stop

@section('breadN2')
    <a href="" class="n2">留言</a>
@stop

@section('article')
    <div class="mt20"></div>
    <div class="message-form">
        <section class="message-title">
            <h1>留言板</h1>
            <p>Tell me what you think！</p>
        </section>
        <form class="layui-form layui-form-pane" action onsubmit="return false">
            @csrf
            <div class="layui-form-item">
                <textarea name="content" lay-verify="content" id="remarkEditor" placeholder="请输入内容"
                          class="layui-textarea layui-hide"></textarea>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="addMessage" lay-filter="addMessage">提交留言</button>
            </div>
        </form>
    </div>

    <div class="mt20 message-list">
        <ul>
            @if(!empty($message))
                @foreach($message as $msg)
                    <div class="gbko">
                        <div class="message-parent">
                            {{--<a name="remark-12"></a>--}}
                            <img src="{{ $msg->avatar }}" alt="{{ $msg->username }}">
                            <div class="info"><span class="username">{{ $msg->username }}</span></div>
                            <div class="message-content">{!! $msg->content !!}</div>
                            <p class="info info-footer">
                                <span class="message-time">{{ $msg->created_at }}</span>
                                <a href="javascript:;" class="btn-reply" data-targetid="{{ $msg->id }}"
                                   data-targetname="{{ $msg->username }}">回复</a>
                            </p>
                        </div>
                        @if(!empty($msg->child))
                            <hr>
                            @foreach($msg->child as $child)
                                <div class="message-child">
                                    {{--<a name="reply-9"></a>--}}
                                    <img src="{{ $child->avatar }}" alt="{{ $child->username }}"/>
                                    <div class="info">
                                        <span class="username">{{ $child->username }}</span>
                                        <span style="padding-right:0;margin-left:-5px;">回复</span>
                                        <span class="username">{{ $child->targetUser }}</span>
                                        <span>: {!! $child->content !!}</span>
                                    </div>
                                    <p class="info">
                                        <span class="message-time">{{ $child->created_at }}</span>
                                        <a href="javascript:;" class="btn-reply" data-targetid="{{ $child->id }}"
                                           data-targetname="{{ $child->username }}">回复</a>
                                    </p>
                                </div>
                            @endforeach
                        @endif
                        <div class="replycontainer layui-hide">
                            <form class="layui-form" action="">
                                @csrf
                                <input type="hidden" name="parentId" value="{{ $msg->id }}">
                                <input type="hidden" name="targetId" value="">
                                <input type="hidden" name="targetUser" value="">
                                <div class="layui-form-item">
                                    <textarea name="content" lay-verify="replyContent" placeholder="请输入回复内容"
                                              class="layui-textarea" style="min-height:80px;"></textarea>
                                </div>
                                <div class="layui-form-item">
                                    <button class="layui-btn layui-btn-xs" lay-submit="addMessage"
                                            lay-filter="addMessage">提交
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </ul>
    </div>
@stop

@section('search')
@stop

@section('cloud')
@stop

@section('script')
    <script src="{{ asset('js/message.js') }}"></script>
@stop