<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->comment('标题');
            $table->string('img')->nullable()->comment('封面图');
            $table->string('summary')->comment('文章简介');
            $table->longText('content')->comment('文章内容');
            $table->string('authorName', 50)->comment('作者名称');
            $table->string('authorEmail', 100)->comment('作者邮箱');
            $table->unsignedInteger('read')->default(0)->comment('阅读量');
            $table->unsignedInteger('comments')->default(0)->comment('评论数');
            $table->unsignedTinyInteger('isTop')->default(2)->index()->comment('是否置顶 1 置顶 2 不置顶');
            $table->unsignedTinyInteger('recommend')->default(2)->index()->comment('是否推荐 1 推荐 2 不推荐');
            $table->unsignedTinyInteger('state')->default(2)->index()->comment('是否展示 1 展示 2 不展示');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog');
    }
}
