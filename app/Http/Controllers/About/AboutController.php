<?php

namespace App\Http\Controllers\About;

use App\Common\PublicController;

class AboutController extends PublicController
{
    /**
     * 关于我内容展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        return $this->responseView('about.index');
    }

    public function hutui()
    {
        return $this->responseView('about.hutui');
    }
}
