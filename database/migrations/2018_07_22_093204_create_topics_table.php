<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('发布人id');
            $table->string('user_name', 80)->comment('发布人名称');
            $table->text('content')->comment('话题内容');
            $table->string('images',254)->comment('话题图片地址');
            $table->integer('comment_count')->default(0)->comment('评论数量');
            $table->integer('look_count')->default(0)->comment('查看数量');
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
        Schema::dropIfExists('topics');
    }
}
