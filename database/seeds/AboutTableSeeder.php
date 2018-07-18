<?php

use Illuminate\Database\Seeder;
use App\Common\Models\About;

class AboutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::truncate();
        $config = config('siteConfig');
        $about  = [
            'siteName'    => $config['siteName'],
            'authorName'  => $config['authorName'],
            'profession'  => $config['profession'],
            'keywords'    => $config['keywords'],
            'description' => $config['description'],
            'mood'        => $config['mood'],
            'content'     => $config['content'],
            'weChat'      => $config['weChat'],
            'weChatQR'    => $config['weChatQR'],
            'qq'          => $config['qq'],
            'email'       => $config['email'],
            'state'       => 1,
        ];
        unset($config);
        About::create($about);
        unset($about);
    }
}
