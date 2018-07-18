<?php


namespace App\Admin\Extensions;


class ShowComments
{
    protected $articleId;

    public function __construct($articleId)
    {
        $this->articleId = $articleId;
    }

    protected function render()
    {
        $href = route('showComments', $this->articleId);
        return "<a class='fa grid-maintain-row maintian-{$this->articleId}-btn' href='{$href}' title='查看评论' data-id='{$this->articleId}'><i class='fa fa-commenting fa-flip-horizontal'></i></a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}