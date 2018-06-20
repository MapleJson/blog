<?php

namespace App\Common\Models;

use App\Common\PublicModel;

class Tag extends PublicModel
{
    protected $table = 'tags';

    protected $primaryKey = "id";

    protected $guarded = ['id'];

    public static $pivot = [];

    public function blog()
    {
        return $this->belongsToMany(Blog::class)->where(self::$pivot);
    }
}