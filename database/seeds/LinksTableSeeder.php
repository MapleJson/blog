<?php

use Illuminate\Database\Seeder;
use App\Common\Models\Link;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Link::truncate();
        Link::create([
            'domain'  => "https://52zoe.com",
            'logo'    => "https://52zoe.com/images/avatar.png",
            'title'   => "秋枫阁",
            'summary' => "秋枫阁，一个PHPer的个人博客。",
            'state'   => 1,
        ]);
    }
}
