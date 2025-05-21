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
        Schema::create('interview_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("talent_id")->default(0)->comment("人才库id");
            $table->integer("relation_id")->default(0)->comment("人才职位关联id");
            $table->tinyInteger("interview_type")->unsigned()->default(0)->comment("面试类型 1:现场面试 2:电话面试 3:视频面试");
            $table->timestamp("interview_time")->comment("面试时间");
            $table->timestamp("cancel_time")->nullable()->comment("取消时间");
            $table->integer("address")->default(0)->comment("面试地址id");
            $table->json("interviews")->comment("面试流程信息");
            $table->tinyInteger("status")->unsigned()->default(1)->comment("参与状态 1:正常 2:取消");
            $table->integer("begin_time")->comment("开始时间");
            $table->integer("end_time")->comment("结束时间");
//            $table->json('interview_assessments')->comment('面试结果');
            $table->string('creator_id',255)->comment("创建人");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->comment("面试记录");
            $table->index('talent_id');
            $table->index('relation_id');
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
