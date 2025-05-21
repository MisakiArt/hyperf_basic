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
        Schema::table('interview_records', function (Blueprint $table) {
            $table->string("feishu_id")->default("")->comment("飞书面试记录id");
            $table->index("feishu_id");
        });
        Schema::table('talents', function (Blueprint $table) {
            $table->index("feishu_id");
        });
        Schema::table('jobs', function (Blueprint $table) {
            $table->index("feishu_id");
        });

        Schema::table('talent_job_relation', function (Blueprint $table) {
            $table->string("delivery_method")->default("")->comment("投递方式");
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
