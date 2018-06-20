@extends('common/layouts')

@section('breadSpan')
    自小刺头深草里，而今渐觉出蓬蒿。时人不识凌云木，直待凌云始道高。
@stop

@section('breadN2')
    <a href="javascript:window.history.back();" class="n2">返回</a>
@stop

@section('leftClass')infos @stop

@section('article')
    <div class="newsview">
        <h3 class="news_title">{{ $info->title }}</h3>
        <div class="news_author">
            <span class="au01"><a href="mailto:{{ $info->authorEmail }}">{{ $info->authorName }}</a></span>
            <span class="au02">{{ $info->created_at }}</span>
            <span class="au03">共<b>{{ $info->read }}</b>人围观</span>
        </div>
        <div class="tags">
            @foreach($info->tags as $tag)
                <a href="{{ route("tags", $tag->id) }}" target="_blank">{{ $tag->name }}</a>&nbsp
            @endforeach
        </div>
        @if(!empty($info->summary))
            <div class="news_about"><strong>简介</strong>{{ $info->summary }}</div>
        @endif
        <div class="news_infos">
            {!! $info->content !!}
        </div>
    </div>
    <div class="share"></div>
    <div class="nextinfo">
        @if(!empty($pre))
            <p>上一篇：<a href="{{ route("info", $pre->id) }}">{{ $pre->title }}</a></p>
        @else
            <p>上一篇：<a href="javascript:;">没有了...</a></p>
        @endif
        @if(!empty($next))
            <p>下一篇：<a href="{{ route("info", $next->id) }}">{{ $next->title }}</a></p>
        @else
            <p>下一篇：<a href="javascript:;">没有了...</a></p>
        @endif
    </div>
    @if(!empty($related))
        <div class="otherlink">
            <h2>相关文章</h2>
            <ul>
                @foreach($related as $relate)
                    <li>
                        <i class="fa fa-book"></i><a href="{{ route("info", $relate->id) }}"
                                                     title="{{ $relate->title }}">{{ $relate->title }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="news_pl">
        <h2>文章评论</h2>
        <form class="layui-form layui-form-pane lay-message-form" action onsubmit="return false">
            @csrf
            <input type="hidden" value="{{ $info->id }}" name="articleId"/>
            <div class="layui-form-item">
                <textarea name="content" lay-verify="content" id="remarkEditor" placeholder="请输入内容"
                          class="layui-textarea layui-hide"></textarea>
            </div>
            <div class="layui-form-item" style="text-align: center">
                <button class="layui-btn" lay-submit="addMessage" lay-filter="addMessage">提交评论</button>
            </div>
        </form>
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
                            <form class="layui-form" action onsubmit="return false">
                                @csrf
                                <input type="hidden" name="parentId" value="{{ $msg->id }}">
                                <input type="hidden" name="targetId" value="">
                                <input type="hidden" name="targetUser" value="">
                                <input type="hidden" name="articleId" value="{{ $info->id }}">
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

@section('aboutUs')
@stop

@section('sidebar')
    @if(!empty($propose))
        <div class="paihang">
            <h2 class="hometitle">站长推荐</h2>
            <ul>
                @foreach($propose as $prop)
                    <li>
                        <b><a href="{{ route("info", $prop->id) }}" target="_blank">{{ $prop->title }}</a></b>
                        <p><i><img src="{{ $prop->img }}"></i><span>{{ $prop->summary }}</span></p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @parent
@stop

@section('script')
    <script src="{{ asset('js/blog.js') }}"></script>
@stop