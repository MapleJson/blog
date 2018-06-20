<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ShowComments;
use App\Common\Models\Blog;
use App\Common\Models\Tag;
use App\Common\PublicController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;

class BlogController extends PublicController
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

            $content->header($this->trans('posts'));
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

            $content->header($this->trans('posts'));
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

            $content->header($this->trans('posts'));
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
        return Admin::grid(Blog::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->title($this->trans('title', 'admin'))->ucfirst()->limit(30);
            $grid->tags($this->trans('tags'))->pluck('name')->label();
            $grid->authorName($this->trans('author'));
            $grid->state($this->trans('release'))->switch($this->trans('states'));
            $grid->isTop($this->trans('top'))->switch($this->trans('states'));
            $grid->recommend($this->trans('recommend'))->switch($this->trans('states'));
            $grid->read($this->trans('read'))->sortable();
            $grid->comments($this->trans('comments'))->sortable();

            $grid->created_at($this->trans('created_at', 'admin'));

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->prepend(new ShowComments($actions->getKey()));
            });

            $grid->filter(function (Grid\Filter $filter) {

                $filter->like('title', $this->trans('title', 'admin'));

                $filter->where(function ($query) {

                    $input = $this->input;

                    $query->whereHas('tags', function ($query) use ($input) {
                        $query->where('name', $input);
                    });

                }, $this->trans('tags'), 'tag');
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
        return Admin::form(Blog::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('authorName', $this->trans('author'));
            $form->display('authorEmail', $this->trans('email', 'admin'));

            $form->hidden('authorName')->default(Admin::user()->username);
            $form->hidden('authorEmail')->default(Admin::user()->email);

            $form->text('title', $this->trans('title', 'admin'))
                ->rules('required|string');
            $form->listbox('tags')
                ->options(Tag::all()->pluck('name', 'id'))
                ->rules('required');

            $form->image('img', $this->trans('cover'))->rules('required');

            $form->text('summary', $this->trans('synopsis'))
                ->rules('required|string');
            $form->editor('content', $this->trans('contents'))
                ->rules('required|string');

            $form->switch('state', $this->trans('release'))
                ->rules('required');
            $form->switch('isTop', $this->trans('top'))
                ->rules('required');
            $form->switch('recommend', $this->trans('recommend'))
                ->rules('required');

            $form->display('created_at', $this->trans('created_at', 'admin'));
            $form->display('updated_at', $this->trans('updated_at', 'admin'));
        });
    }
}
