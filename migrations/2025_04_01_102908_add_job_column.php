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
        Schema::table('jobs', function (Blueprint $table) {
            $table->json('process_info')->comment("流程信息");
            $table->json('evaluator_id')->comment("评估人");
        });

//        Schema::table('talents', function (Blueprint $table){
//            $table->tinyInteger('status')->default(0)->comment("简历状态 0:简历初筛 1:简历评估 2:面试 3:offer沟通 4:待入职 5:已入职 6:已终止");
//
//            $table->text('evaluate')->default("")->comment("评价");
//            $table->integer('evaluate_result')->default(2)->comment("评价结果 1:通过 2:不通过");
//            $table->string('evaluator_id',255)->default("")->comment("评价人");
//        });
//        Schema::create('interview_records', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->integer("talent_id")->default(0)->comment("人才库id");
//            $table->integer("relation_id")->default(0)->comment("人才职位关联id");
//            $table->tinyInteger("interview_type")->unsigned()->default(0)->comment("面试类型 1:现场面试 2:电话面试 3:视频面试");
//            $table->timestamp("interview_time")->comment("面试时间");
//            $table->tinyInteger("participate_status")->unsigned()->default(1)->comment("参与状态 1:未参与 2:参与 3:爽约");
//            $table->timestamp("begin_time")->comment("开始时间");
//            $table->timestamp("end_time")->comment("结束时间");
//            $table->json('interview_assessments')->comment('面试结果');
//            $table->string('creator_id',255)->comment("创建人");
//            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
//            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
//            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
//            $table->comment("面试记录");
//            $table->index('talent_id');
//        });


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
