<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('articleId')->default(0)->index()->comment('文章ID');
            $table->unsignedInteger('parentId')->default(0)->index()->comment('主评论ID');
            $table->unsignedInteger('targetId')->default(0)->index()->comment('被回复人ID');
            $table->string('targetUser', 50)->default("")->comment('被回复人名称');
            $table->string('avatar', 100)->comment('回复人头像');
            $table->string('username', 50)->comment('回复人名称');
            $table->text('content')->comment('回复内容');
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
        Schema::dropIfExists('messages');
    }
}
