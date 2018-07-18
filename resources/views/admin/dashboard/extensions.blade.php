<style>
    .ext-icon {
        color: rgba(0, 0, 0, 0.5);
        margin-left: 10px;
    }

    .installed {
        color: #00a65a;
        margin-right: 10px;
    }
</style>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">最新文章阅读量</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <ul class="products-list product-list-in-box">

            @if(!empty($extensions))
                @foreach($extensions as $extension)
                    <li class="item">
                        <div class="product-img">
                            <i class="fa fa-{{$extension['icon']}} fa-2x ext-icon"></i>
                        </div>
                        <div class="product-info">
                            <a href="{{ $extension['link'] }}" target="_blank" class="product-title">
                                {{ $extension['name'] }}
                            </a>
                            <span class="pull-right installed">{{ $extension['read'] }}</span>
                        </div>
                    </li>
                @endforeach

            @else
                暂无数据
            @endif

        <!-- /.item -->
        </ul>
    </div>
    <!-- /.box-body -->
    <!-- /.box-footer -->
</div>