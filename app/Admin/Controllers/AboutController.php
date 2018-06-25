<?php

namespace App\Admin\Controllers;

use App\Common\Extensions\Code;
use App\Common\Models\About;
use App\Common\PublicController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;

class AboutController extends PublicController
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

            $content->header($this->trans('about'));
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

            $content->header($this->trans('about'));
            $content->description($this->trans('edit', 'admin'));

            $content->body($this->form()->edit($id));
        });
    }

//    /**
//     * Create interface.
//     *
//     * @return Content
//     */
//    public function create()
//    {
//        return Admin::content(function (Content $content) {
//
//            $content->header($this->trans('posts'));
//            $content->description($this->trans('create', 'admin'));
//
//            $content->body($this->form());
//        });
//    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(About::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->siteName($this->trans('siteName'))->label();
            $grid->authorName($this->trans('author'))->label();
            $grid->profession($this->trans('profession'));
            $grid->weChat($this->trans('weChat'));
            $grid->qq($this->trans('qq'));
            $grid->email($this->trans('email', 'admin'));
            $grid->state($this->trans('isShow'))->switch($this->trans('states'));

            $grid->disableExport();
            $grid->disableCreateButton();
            $grid->disableRowSelector();
            $grid->disableFilter();
            $grid->disablePagination();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(About::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('siteName', $this->trans('siteName'))
                ->rules('required|string');
            $form->text('authorName', $this->trans('author'))
                ->rules('required|string');
            $form->text('profession', $this->trans('profession'))
                ->rules('required|string');
            $form->text('keywords', $this->trans('keywords'))
                ->rules('required|string');
            $form->text('description', $this->trans('description'))
                ->rules('required|string');
            $form->text('mood', $this->trans('mood'))
                ->rules('required|string');

            $form->editor('content', $this->trans('contents'))
                ->rules('required|string');

            $form->text('weChat', $this->trans('weChat'))
                ->rules('required|string');

            $form->image('weChatQR', $this->trans('weChatQR'))
                ->uniqueName()
                ->rules('required');

            $form->number('qq', $this->trans('qq'))
                ->rules('required');

            $form->email('email', $this->trans('email', 'admin'))
                ->rules('required');

            $form->switch('state', $this->trans('isShow'))
                ->default(Code::NO)
                ->states($this->trans('states'))
                ->rules('required');

            $form->display('created_at', $this->trans('created_at', 'admin'));
            $form->display('updated_at', $this->trans('updated_at', 'admin'));
        });
    }
}
