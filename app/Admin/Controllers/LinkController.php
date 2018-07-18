<?php

namespace App\Admin\Controllers;

use App\Common\Extensions\Code;
use App\Common\Models\Link;
use App\Common\PublicController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;

class LinkController extends PublicController
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

            $content->header($this->trans('links'));
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

            $content->header($this->trans('links'));
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

            $content->header($this->trans('links'));
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
        return Admin::grid(Link::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->title($this->trans('title', 'admin'));
            $grid->logo('LOGO')->image(null, 50, 50);
            $grid->domain($this->trans('domain'))->display(function ($domain) {
                return "<a href='{$domain}' target='_blank'>{$domain}</a>";
            });
            $grid->state($this->trans('isShow'))->switch($this->trans('states'));

            $grid->created_at($this->trans('created_at', 'admin'));

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('domain', $this->trans('domain'));
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
        return Admin::form(Link::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title', $this->trans('title', 'admin'))
                ->rules('required|string');
            $form->url('logo', 'LOGO');
            $form->url('domain', $this->trans('domain'));
            $form->textarea('summary', $this->trans('synopsis'));

            $form->switch('state', $this->trans('isShow'))
                ->default(Code::NO)
                ->states($this->trans('states'))
                ->rules('required');

            $form->display('created_at', $this->trans('created_at', 'admin'));
            $form->display('updated_at', $this->trans('updated_at', 'admin'));
        });
    }
}
