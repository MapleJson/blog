<?php

namespace App\Common\Models;

use App\Common\PublicModel;

class Thumb extends PublicModel
{
    protected $table = 'thumbs';

    protected $primaryKey = "id";

    protected $guarded = ['id'];
}