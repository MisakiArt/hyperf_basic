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
        Schema::table('talents', function (Blueprint $table) {
            $table->string("feishu_id",255)->default("")->comment("飞书对应id");
        });

        Schema::table('jobs', function (Blueprint $table) {
            $table->string("feishu_id",255)->default("")->comment("飞书对应id");
        });

        Schema::table('talent_job_relation', function (Blueprint $table) {
            $table->string("feishu_id",255)->default("")->comment("飞书对应id");
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
