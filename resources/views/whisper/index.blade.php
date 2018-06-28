@extends('common/layouts')

@section('title')
    耳语
@stop

@section('breadSpan')
    执子之手，相濡以沫，耳鬓厮磨，白首不离，我心驰神往。
@stop

@section('breadN2')
    <a href="{{ route('whisper') }}" class="n2">耳语</a>
@stop

@section('leftClass')whisper @stop

@section('article')
    <div class="whisper-timeline mt20">
        <ul class="layui-timeline" id="LAY_whisper_load"></ul>
    </div>
@stop

@section('cloud')
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
    <script type='text/javascript' src="{{ asset('js/whisper.js') }}"></script>
@stop