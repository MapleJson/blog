<?php

namespace App\Common\Models;

use App\Common\Extensions\Code;
use App\Common\PublicModel;

class Blog extends PublicModel
{
    protected $table = 'blog';

    protected $primaryKey = "id";

    protected $guarded = ['id'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->where("state", Code::ENABLED_STATUS);
    }

    public static function getList(int $type = Code::YES)
    {
        // 一般情况下新增的ID越大所以此处我用id，也可以按时间排序self::CREATED_AT
        return parent::getList($type)
            ->orderBy("isTop", 'asc')
            ->orderBy("id", 'desc')
            ->get();
    }

    /**
     * 获取下一篇文章的ID
     *
     * 因为列表页是按照时间倒序排列
     * 所以下一篇的id应该比当前文章id小
     *
     * @param int $id
     * @return mixed
     */
    public static function getNextArticleId(int $id)
    {
        return self::where('id', '<', $id)
            ->where('state', Code::ENABLED_STATUS)
            ->max('id');
    }

    /**
     * 获取上一篇文章的ID
     *
     * 因为列表页是按照时间倒序排列
     * 所以上一篇的id应该比当前文章id大
     *
     * @param int $id
     * @return mixed
     */
    public static function getPrevArticleId(int $id)
    {
        return self::where('id', '>', $id)
            ->where('state', Code::ENABLED_STATUS)
            ->min('id');
    }

    /**
     * 获取站长推荐列表
     * @return mixed
     */
    public static function recommendBlog()
    {
        /*
         * 站长推荐
         */
        self::_destroy();
        self::$where = [
            'recommend' => Code::ENABLED_STATUS,
            'state'     => Code::ENABLED_STATUS,
        ];
        self::$limit = [
            'limit'  => config("siteConfig.proposeCount"),
            'offset' => 0,
        ];
        $recommend   = self::getList();
        self::_destroy();
        foreach ($recommend as &$item) {
            $item->img = self::uploadImageUrl($item->img);
        }

        return $recommend;
    }
}