<?php

namespace App\Common\Models;

use App\Common\Extensions\Code;
use App\Common\PublicModel;

class Tag extends PublicModel
{
    protected $table = 'tags';

    protected $primaryKey = "id";

    protected $guarded = ['id'];

    public static $pivot = [];

    public function blog()
    {
        return $this->belongsToMany(Blog::class)
            ->where(self::$pivot)
            ->orderBy("isTop", 'asc')
            ->orderBy("id", 'desc');
    }

    public static function getList(int $type = Code::YES)
    {
        return parent::getList($type)
            ->orderBy("id", 'desc')
            ->get();
    }
}