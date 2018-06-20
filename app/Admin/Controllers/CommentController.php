<?php

namespace App\Admin\Controllers;

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
    public function index($articleId)
    {
        return Admin::content(function (Content $content) use ($articleId) {

            $content->header($this->trans('discuss'));
            $content->description($this->trans('list', 'admin'));

            $content->body($this->grid($articleId));
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
                return $content;
            });;
            $grid->state($this->trans('isShow'))->switch($this->trans('states'));

            $grid->created_at($this->trans('created_at', 'admin'));

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('content', $this->trans('contents', 'admin'));
            });

            $grid->disableExport();
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableRowSelector();
        });
    }

}
