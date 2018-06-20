<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain', 100)->comment('链接');
            $table->string('logo', 200)->comment('logo链接');
            $table->string('title', 30)->comment('站点名称');
            $table->string('summary', 200)->comment('站点说明');
            $table->unsignedTinyInteger('state')->default(2)->index()->comment('审核状态 1 通过 2 待审核 3 不通过');
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
        Schema::dropIfExists('links');
    }
}
