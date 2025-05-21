<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hires', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name")->default("")->comment("名称");
            $table->integer("talent_id")->default(0)->comment("人才id");
            $table->string("mobile")->default("")->comment("手机号");
            $table->json("registration_form")->comment("入职登记表");
            $table->integer('hire_status')->default(0)->comment("入职状态0:未生效 1:已入职 2:待入职 3:已取消");
            $table->string("hire_time")->default("")->comment("入职时间");
            $table->string("hire_operator")->default("")->comment("入职操作人");
            $table->string("expected_hire_time")->default("")->comment("预计入职时间");
            $table->string('creator_id',255)->comment("创建人");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->comment("入职管理");
            $table->index('expected_hire_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
