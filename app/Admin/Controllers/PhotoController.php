<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\PhotoDelete;
use App\Common\Extensions\Code;
use App\Common\Models\Photo;
use App\Common\PublicController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;

class PhotoController extends PublicController
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @param int $travelId
     * @return Content
     */
    public function index(int $travelId)
    {
        return Admin::content(function (Content $content) use ($travelId) {

            $content->header($this->trans('travels'));
            $content->description($this->trans('list', 'admin'));

            $content->body($this->grid($travelId));
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

            $content->header($this->trans('travels'));
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

            $content->header($this->trans('travels'));
            $content->description($this->trans('create', 'admin'));

            $content->body($this->form());
        });
    }

    public function upload()
    {

    }

    /**
     * Make a grid builder.
     *
     * @param int $travelId
     * @return Grid
     */
    protected function grid(int $travelId)
    {
        return Admin::grid(Photo::class, function (Grid $grid) use ($travelId) {
            $grid->model()->where('travelId', $travelId)->orderBy('id', 'desc');

            $grid->id('ID');
            $grid->img()->image();
            $grid->summary()->limit(20);

            $grid->resource("/admin/photos");

            $grid->setView('admin.grid.photo');

            $grid->disableExport();
            $grid->disableFilter();
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
        return Admin::form(Photo::class, function (Form $form) {

            $form->tools(function (Form\Tools $tools) {
                // 去掉跳转列表按钮
                $tools->disableListButton();
            });

            $form->display('id', 'ID');

            $form->image('img',$this->trans('photos'))
                ->readOnly();

            $form->text('summary', $this->trans('synopsis'))
                ->rules('required|string');

            $form->switch('state', $this->trans('isShow'))
                ->default(Code::NO)
                ->states($this->trans('states'))
                ->rules('required');

            $form->display('created_at', $this->trans('created_at', 'admin'));
            $form->display('updated_at', $this->trans('updated_at', 'admin'));
        });
    }
}
