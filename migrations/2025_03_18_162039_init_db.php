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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('union_id','255')->default('')->comment("应用开发商发布的不同应用中同一用户的标识");
            $table->string('user_id','255')->default('')->comment("租户内用户的唯一标识");
            $table->string('open_id','255')->default('')->comment("应用内用户的唯一标识");
            $table->string('name','255')->default('')->comment("用户名称");
            $table->string('en_name','255')->default('')->comment("英文名");
            $table->string('nickname','255')->default('')->comment("别名");
            $table->string('email','255')->default('')->comment("邮箱");
            $table->string('mobile','255')->default('')->comment("手机号");
            $table->boolean('mobile_visible')->default(true)->comment("手机号码是否可见");
            $table->tinyInteger('gender')->default(0)->comment("性别 ");
            $table->json("avatar")->nullable()->comment("用户头像信息。");
            $table->json("department_ids")->nullable()->comment("部门ids");
            $table->integer("is_frozen")->default(0)->comment("是否为暂停状态");
            $table->integer("is_activated")->default(0)->comment("是否激活");
            $table->integer("is_exited")->default(0)->comment("是否为主动退出状态");
            $table->integer("is_resigned")->default(0)->comment("是否离职");
            $table->integer("is_unjoin")->default(0)->comment("是否为未加入状态");
            $table->string('leader_user_id','255')->default('')->comment("用户的直接主管的用户ID");
            $table->string('city','255')->default('')->comment("工作城市");
            $table->string('country','10')->default('')->comment("国家或地区 Code 缩写");
            $table->string('work_station','255')->default('')->comment("工位");
            $table->integer('join_time')->default(0)->comment("入职时间");
            $table->tinyInteger('is_tenant_manager')->default(0)->comment("
用户是否为租户超级管理员");
            $table->string('employee_no','50')->default('')->comment("工号");
            $table->tinyInteger('employee_type')->default(1)->comment("员工类型1：正式员工 2：实习生 3：外包 4：劳务 5：顾问");
            $table->string('job_title',255)->default("")->comment("职务");
            $table->string('geo',10)->default("")->comment("数据驻留地");
            $table->string('job_level_id',255)->default("")->comment("职级 ID");
            $table->string('job_family_id',255)->default("")->comment("序列 ID");
            $table->string('enterprise_email',255)->default("")->comment("企业邮箱");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->index('union_id');
            $table->index('user_id');
            $table->index('open_id');
            $table->index('enterprise_email');
        });
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name','255')->default('')->comment("部门名称");
            $table->string('parent_department_id','255')->default('')->comment("父部门的部门 ID");
            $table->string('department_id','255')->default('')->comment("自定义部门 ID");
            $table->string('open_department_id','255')->default('')->comment("部门的 open_department_id，由系统自动生成。后续可以使用该 ID 删除、修改、查询部门信息。");
            $table->string('leader_user_id','255')->default('')->comment("部门主管的用户 ID");
            $table->string('chat_id','255')->default('')->comment("部门群的群 ID");
            $table->string('order','255')->default('')->comment("部门的排序，即部门在其同级部门的展示顺序。取值越小排序越靠前");
            $table->integer('member_count')->default(0)->comment("当前部门及其下属部门的用户（包含部门负责人）个数");
            $table->json('department_hrbps')->nullable()->comment("部门 HRBP 的用户 ID 列表");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->index('department_id');
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
