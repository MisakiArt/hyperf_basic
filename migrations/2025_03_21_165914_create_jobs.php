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
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',50)->default('')->comment("职位名称");
            // $table->integer('experience')->default(1)->comment("工作经验要求 1:1：不限 2：应届毕业生 3：1年以下 4：1-3年 5：3-5年 6：5-7年 7：7-10年 8：10年以上");
            // $table->string('min_salary',50)->default('')->comment("最低月薪");
            //$table->string('max_salary',50)->default('')->comment("最高月薪");
            $table->text('requirement')->default('')->comment("职位要求");
            $table->text('description')->default('')->comment("职位描述");
            $table->tinyInteger('process_type')->default(1)->comment("职位流程类型 1:社招 2:校招");
            // $table->tinyInteger('required_degree')->default(1)->comment("学历要求 1：小学及以上 2：初中及以上 3：专职及以上 4：高中及以上 5：大专及以上");
            $table->integer('head_count')->default(1)->comment("招聘数量");
            $table->integer('employment_type')->default(1)->comment("雇佣类型 101:社招-全职 102:社招-外包 103:社招-劳务 105:社招-顾问 301:社招-实习 201:校招-正式 202:校招-实习");
            $table->string("job_type")->default("")->comment("职位类别");
            $table->string("department")->default("")->comment("部门");
            $table->string("work_place",255)->default('')->comment("工作地点");
            $table->string('charger_id',255)->default('')->comment("招聘负责人");
            $table->json('employment_manager_id')->nullable()->comment("用人经理id");
            $table->json('supporter_id')->nullable()->comment("协作人id");
            $table->string('creator_id',255)->default('')->comment("创建人id");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->index('creator_id');
        });
        \Hyperf\DbConnection\Db::statement("ALTER TABLE `tb_hr_jobs` COMMENT = '职位'");
        \Hyperf\DbConnection\Db::statement("ALTER TABLE `tb_hr_users` COMMENT = '用户表'");
        \Hyperf\DbConnection\Db::statement("ALTER TABLE `tb_hr_departments` COMMENT = '部门表'");
        \Hyperf\DbConnection\Db::statement("ALTER TABLE `tb_hr_talents` COMMENT = '人才库'");
        \Hyperf\DbConnection\Db::statement("ALTER TABLE `tb_hr_dictionary` COMMENT = '字典'");

        Schema::table('talents', function (Blueprint $table) {
            $table->json('resume_file_path')->comment("简历地址");
        });
        Schema::table('jobs', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->comment("状态 1:开启 2:关闭");
        });

    }

    /**
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
