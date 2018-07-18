<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhispersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whispers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('author')->default("")->comment('作者');
            $table->longText('content')->comment('内容');
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
        Schema::dropIfExists('whispers');
    }
}
