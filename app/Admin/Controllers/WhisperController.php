<?php

namespace App\Admin\Controllers;

use App\Common\Extensions\Code;
use App\Common\Models\Whisper;
use App\Common\PublicController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;

class WhisperController extends PublicController
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header($this->trans('whisper'));
            $content->description($this->trans('list', 'admin'));

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header($this->trans('whisper'));
            $content->description($this->trans('edit', 'admin'));

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header($this->trans('whisper'));
            $content->description($this->trans('create', 'admin'));

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Whisper::class, function (Grid $grid) {

            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->author($this->trans('author'));
            $grid->content($this->trans('contents'))->ucfirst()->limit(30);
            $grid->state($this->trans('release'))->switch($this->trans('states'))->sortable();
            $grid->created_at($this->trans('created_at', 'admin'));

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('content', $this->trans('contents'));
            });

            $grid->disableExport();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Whisper::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('author', $this->trans('author'));

            $form->hidden('author')->default(Admin::user()->username);

            $form->editor('content', $this->trans('contents'))
                ->rules('required|string');

            $form->switch('state', $this->trans('release'))
                ->default(Code::NO)
                ->states($this->trans('states'))
                ->rules('required');

            $form->display('created_at', $this->trans('created_at', 'admin'));
            $form->display('updated_at', $this->trans('updated_at', 'admin'));
        });
    }
}
