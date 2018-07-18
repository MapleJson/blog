<?php

namespace App\Admin\Controllers;

use App\Common\Extensions\Code;
use App\Common\Models\Blog;
use App\Common\Models\Message;
use App\Common\PublicController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Form as RForm;

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

            $grid->resource("/admin/comment");

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

            $author = $this->trans("siteAdmin");
            $grid->actions(function (Grid\Displayers\Actions $actions) use ($author) {
                if ($actions->row->username !== $author) {
                    $actions->prepend('<a href="' . route("replyForm", $actions->getKey()) . '"><i class="fa fa-paper-plane"></i></a>');
                }
            });

            $grid->disableExport();
            $grid->disableCreateButton();
            $grid->disableRowSelector();
        });
    }

    public function replyForm(int $id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header($this->trans('reply'));

            $this->showFormParameters($content);

            $form = new RForm();

            $form->method('post');
            $form->action(route("replySave", $id));

            $comment = Message::getOne($id);

            $form->hidden('id')->default($comment->id);
            if ($comment->articleId > 0) {
                $form->hidden('articleId')->default($comment->articleId);
            }
            $form->hidden('parentId')->default($comment->parentId > 0 ? $comment->parentId : $comment->id);
            $form->hidden('targetId')->default($comment->id);
            $form->hidden('targetUser')->default($comment->username);
            $form->display('targetUser', $this->trans("targetUser"))->default($comment->username);
            $form->display('content', $this->trans("contents"))->default($comment->content);
            $form->textarea('content', $this->trans("contents"));

            $content->body(new Box($this->trans('reply'), $form));
        });
    }

    public function replySave(int $id)
    {
        $post = self::getValidateParam("addMessage");

        if (empty($post['targetUser']) || empty(trim($post['content']))) {
            admin_toastr($this->trans("formValidateFail"), 'error');
            return back();
        }

        /*
         * 添加留言，此处默认通过审核，可以修改为审核后才展示
         * 'state'    => Code::DISABLED_STATUS
         */
        Message::$data = [
            'avatar'   => Admin::user()->avatar,
            'username' => $this->trans("siteAdmin"),
            'content'  => trim($post['content']),
            'state'    => Code::ENABLED_STATUS,
        ];
        if (empty($post['articleId'])) {
            Message::$data['articleId'] = Code::EMPTY;
        } else {
            Message::$data['articleId'] = (int)trim($post['articleId']);
            Blog::incrementComments((int)trim($post['articleId']));
        }

        Message::$data['parentId']   = (int)trim($post['parentId']);
        Message::$data['targetId']   = (int)trim($post['targetId']);
        Message::$data['targetUser'] = trim($post['targetUser']);

        if (!Message::addToData()) {
            admin_toastr($this->trans("replyError"));
            return back();
        }

        admin_toastr($this->trans("replySuccess"));
        if (!empty($post['articleId'])) {
            return redirect("/admin/comment/" . (int)trim($post['articleId']));
        }
        return redirect("/admin/comment");
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

    protected function showFormParameters($content)
    {
        $parameters = request()->except(['_pjax', '_token']);

        if (!empty($parameters)) {

            ob_start();

            dump($parameters);

            $contents = ob_get_contents();

            ob_end_clean();

            $content->row(new Box('Form parameters', $contents));
        }
    }

}
