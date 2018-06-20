<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('avatar', 100)->nullable()->comment('用户头像');
            $table->string('username', 50)->nullable()->comment('用户名称');
            $table->string('nickname', 50)->comment('用户昵称');
            $table->string('email', 100)->nullable()->comment('用户邮箱');
            $table->string('password', 60)->nullable()->comment('用户密码');
            $table->string('confirmationToken', 60)->nullable()->comment('token');
            $table->string('remember_token', 100)->nullable()->comment('remember_token');
            $table->unsignedBigInteger('githubId')->nullable()->comment('github登录ID');
            $table->string('githubName')->nullable()->comment('github账户名称');
            $table->string('githubUrl')->nullable()->comment('github地址');
            $table->string('qqOpenid')->nullable()->comment('QQ登录ID');
            $table->unsignedBigInteger('wbOpenId')->nullable()->comment('微博登录ID');
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
        Schema::dropIfExists('users');
    }
}
