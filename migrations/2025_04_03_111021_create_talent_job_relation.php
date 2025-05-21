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
//        Schema::table('talent_job_relation', function (Blueprint $table) {
//            $table->tinyInteger('stop_pre_status')->default(0)->comment("终止前状态 0:简历初筛 1:简历评估 2:面试 3:offer沟通 4:待入职 5:已入职 6:已终止");
//        });
//        return;

        Schema::create('talent_job_relation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("talent_id")->default(0)->comment("人才id");
            $table->integer("job_id")->default(0)->comment("职位id");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->tinyInteger('status')->default(0)->comment("流程 0:简历初筛 1:简历评估 2:面试 3:offer沟通 4:待入职 5:已入职 6:已终止");
            $table->json("evaluate_able_ids")->comment("可评估人id");
            $table->string("evaluate_arranger")->comment("评估安排者");
            $table->string("remark")->default("")->comment("设置评估人备注");
            $table->timestamp("evaluate_able_time")->comment("设置评估人时间");
//            $table->text('evaluate')->default("")->comment("评价");
//            $table->integer('evaluate_result')->default(2)->comment("评价结果 1:通过 2:不通过");
//            $table->string('evaluator_id',255)->default("")->comment("评价人");
            $table->json("evaluate_results")->comment("评估结果");
            $table->tinyInteger('stop_pre_status')->default(0)->comment("终止前状态 0:简历初筛 1:简历评估 2:面试 3:offer沟通 4:待入职 5:已入职 6:已终止");
            $table->tinyInteger('stop_type')->default(0)->comment("终止类型 1:我们拒绝了候选人 2:候选人拒绝了我们 3:其他");
            $table->json('stop_reason')->comment("终止原因");
            $table->comment("职位和job的关联表");
            $table->index('talent_id');
            $table->index('job_id');
        });




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent_job_relation');
    }
};
