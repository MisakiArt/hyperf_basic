<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('talent_job_relation', function (Blueprint $table) {
            $table->integer("send_stop_message_time")->default(0)->comment("拒信发送时间");
            $table->index("send_stop_message_time");
            $table->json("message_content")->nullable()->comment("消息内容");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('', function (Blueprint $table) {
            //
        });
    }
};
