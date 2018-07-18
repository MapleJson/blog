<?php

namespace App\Admin\Controllers;

use App\Common\Extensions\Code;
use App\Common\Models\Blog;
use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->row($this->title());

            $content->row(function (Row $row) {

                $row->column(12, function (Column $column) {
                    $column->append($this->extensions());
                });

            });
        });

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private static function title()
    {
        return view('admin::dashboard.title');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function extensions()
    {
        Blog::$limit = [
            'limit'  => 8,
            'offset' => 0,
        ];
        Blog::$where = ['state' => Code::ENABLED_STATUS];

        $data = Blog::getList();
        foreach ($data as $blog) {
            $extensions[] = [
                'name' => $blog->title,
                'link' => route('info', $blog->id),
                'icon' => 'book',
                'read' => $blog->read,
            ];
        }

        return view('admin::dashboard.extensions', compact('extensions'));
    }
}
