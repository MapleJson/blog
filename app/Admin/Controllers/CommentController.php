<?php

namespace App\Admin\Controllers;

use App\Common\Extensions\Code;
use App\Common\Models\Message;
use App\Common\PublicController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;

class CommentController extends PublicController
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @param int $articleId
     *
     * @return Content
     */
    public function index($articleId = Code::EMPTY)
    {
        return Admin::content(function (Content $content) use ($articleId) {

            $content->header($this->trans($articleId ? 'discuss' : 'messages'));
            $content->description($this->trans('list', 'admin'));

            $content->body($this->grid($articleId));
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

            $content->header($this->trans('messages'));
            $content->description($this->trans('edit', 'admin'));

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Make a grid builder.
     *
     * @param int $articleId
     *
     * @return Grid
     */
    protected function grid($articleId)
    {
        return Admin::grid(Message::class, function (Grid $grid) use ($articleId) {

            $grid->model()->where('articleId', $articleId)->orderBy('id', 'desc');

            $grid->username($this->trans('commentUser'))->label();

            $grid->targetUser($this->trans('targetUser'))
                ->display(function ($targetUser) {
                    if ($targetUser === $this->trans('author')) {
                        return "<span class='badge'>{$targetUser}</span>";
                    } else {
                        return "<span class='label label-info'>{$targetUser}</span>";
                    }
                });

            $grid->content($this->trans('contents'))->display(function ($content) {
                return "<div style='max-width: 700px'>{$content}</div>";
            });;
            $grid->state($this->trans('isShow'))->switch($this->trans('states'));

            $grid->created_at($this->trans('created_at', 'admin'));

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('content', $this->trans('contents'));
            });

            $grid->disableExport();
            $grid->disableCreateButton();
            $grid->disableRowSelector();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Message::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('username', $this->trans('commentUser'));
            $form->display('targetUser', $this->trans('targetUser'));
            $form->display('content', $this->trans('contents'));

            $form->switch('state', $this->trans('isShow'))
                ->default(Code::NO)
                ->states($this->trans('states'))
                ->rules('required');

            $form->display('created_at', $this->trans('created_at', 'admin'));
            $form->display('updated_at', $this->trans('updated_at', 'admin'));
        });
    }

}
