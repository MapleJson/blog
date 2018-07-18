<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about', function (Blueprint $table) {
            $table->increments('id');
            $table->string('siteName', 50)->comment('站点名称');
            $table->string('authorName', 50)->comment('作者名称');
            $table->string('profession', 200)->comment('职业');
            $table->string('keywords', 200)->nullable()->comment('关键字');
            $table->string('description', 200)->nullable()->comment('站点说明');
            $table->string('mood', 200)->nullable()->comment('一句话描述自己');
            $table->text('content')->comment('一篇关于我的文章');
            $table->string('weChat', 50)->nullable()->comment('微信号');
            $table->string('weChatQR', 50)->nullable()->comment('微信二维码图片');
            $table->unsignedBigInteger('qq')->nullable()->comment('QQ号');
            $table->string('email', 100)->nullable()->comment('邮箱');
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
        Schema::dropIfExists('about');
    }
}
