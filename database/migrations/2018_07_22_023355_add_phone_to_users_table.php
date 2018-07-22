<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('phone', 11)->after('name')->comment('手机号');
            $table->string('avatar', 200)->after('phone')->default('')->comment('头像');
            $table->integer('topic_count')->after('avatar')->default(0)->comment('发帖数量');
            $table->integer('idol_count')->after('topic_count')->default(0)->comment('关注人数量');
            $table->integer('fans_count')->after('idol_count')->default(0)->comment('粉丝数量');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'avatar',
                'topic_count',
                'idol_count',
                'fans_count',
            ]);
        });
    }
}
