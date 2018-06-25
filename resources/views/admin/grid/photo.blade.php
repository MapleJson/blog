<div class="box">
    <div class="box-header">

        <h3 class="box-title"></h3>

        <span style="position: absolute;left: 10px;top: 5px;">
            {!! $grid->renderHeaderTools() !!}
            <label class="btn btn-default btn"{{-- data-toggle="modal" data-target="#uploadModal"--}}>
                <i class="fa fa-upload"></i>&nbsp;&nbsp;{{ trans('admin.upload') }}
                    <form action="{{ $url['upload'] or '' }}" method="post" class="file-upload-form"
                          enctype="multipart/form-data" pjax-container>
                    <input type="file" name="files[]" class="hidden file-upload" multiple>
                        {{ csrf_field() }}
                </form>
            </label>
        </span>

        <div class="box-tools">
            {!! $grid->renderFilter() !!}
            {!! $grid->renderExportButton() !!}
            {!! $grid->renderCreateButton() !!}
        </div>

    </div>
    <!-- /.box-header -->
    <div class="box-footer">
        <ul class="mailbox-attachments clearfix">
            @foreach($grid->rows() as $row)
                <li>
                    <span class="mailbox-attachment-icon has-img">
                        {!! $row->column('img') !!}
                    </span>
                    <div class="mailbox-attachment-info">
                        <span>{!! $row->column('summary') !!}</span>
                        <br/>
                        <span class="mailbox-attachment-size">
                              {!! $row->column('__row_selector__') !!}
                            <span class="pull-right">
                                {!! $row->column('__actions__') !!}
                            </span>
                        </span>
                    </div>
                </li>
            @endforeach
        </ul>

    </div>
    <div class="box-footer clearfix">
        {!! $grid->paginator() !!}
    </div>
    <!-- /.box-body -->
</div>