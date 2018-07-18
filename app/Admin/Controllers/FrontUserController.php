<?php

namespace App\Admin\Controllers;

use App\Common\Extensions\Code;
use App\User;
use App\Common\PublicController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;

class FrontUserController extends PublicController
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

            $content->header($this->trans('frontUser'));
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

            $content->header($this->trans('frontUser'));
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

            $content->header($this->trans('frontUser'));
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
        return Admin::grid(User::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->username($this->trans('username', 'admin'));
            $grid->githubName($this->trans('githubName'));
            $grid->qqOpenid('QQOpenId');
            $grid->wbOpenId('WeiBoOpenId');
            $grid->state($this->trans('isUse'))->switch($this->trans('states'));

            $grid->created_at($this->trans('created_at', 'admin'));

            $grid->disableExport();
            $grid->disableCreateButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('avatar', $this->trans('avatar', 'admin'));
            $form->display('username', $this->trans('username', 'admin'));
            $form->display('nickname', $this->trans('nickname'));
            $form->display('email', $this->trans('email', 'admin'));
            $form->display('confirmationToken', 'Token');
            $form->display('githubId', 'GitHubId');
            $form->display('githubName', $this->trans('githubName'));
            $form->display('githubUrl', $this->trans('githubUrl'));
            $form->display('qqOpenid', 'QQOpenId');
            $form->display('wbOpenId', 'WeiBoOpenId');

            $form->switch('state', $this->trans('isUse'))
                ->default(Code::NO)
                ->states($this->trans('states'))
                ->rules('required');

            $form->display('created_at', $this->trans('created_at', 'admin'));
            $form->display('updated_at', $this->trans('updated_at', 'admin'));
        });
    }
}
