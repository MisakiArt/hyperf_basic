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
        Schema::create('talents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50)->default('')->comment("姓名");
            $table->string('avatar',255)->default('')->comment("头像");
            $table->string('mobile',50)->default('')->comment("手机");
            $table->string('email',255)->default('')->comment("邮箱");
            $table->tinyInteger('identification_type')->default(1)->comment("证件类型1:中国 - 居民身份证 2:护照 3:中国 - 港澳居民居住证 4:中国 - 台湾居民来往大陆通行证 5:其他");
            $table->string('identification_number',255)->default('')->comment("证件号");
            $table->date('start_work_time')->nullable()->comment("开始工作时间");
            $table->tinyInteger('work_year')->nullable()->comment("工作年限");
            $table->date('birthday')->nullable()->comment("生日");
            $table->tinyInteger('gender')->default(3)->comment("性别 1:男 2:女 3:其他");
            $table->tinyInteger('age')->default(0)->comment("年龄");
            $table->string('current_city',50)->default("")->comment("所在地");
            $table->string('hometown_city',50)->default("")->comment("老家");
            $table->string('nationality',50)->default("")->comment("国籍");
            $table->string('expect_city',50)->default("")->comment("期望工作地点");
            $table->string('talent_source',50)->default("")->comment("简历来源");
            $table->string('delivery_method',50)->default("")->comment("投递方式");
            $table->integer('position_id')->default(0)->comment("加入职位");
            $table->string('file_path',50)->default("")->comment("加入文件夹");
            $table->json("education_list")->nullable()->comment("教育经历");
            $table->json("career_list")->nullable()->comment("工作经历");
            $table->json("project_list")->nullable()->comment("项目经历");
            $table->json("internship_list")->nullable()->comment("实习经历");
            $table->json("works_list")->nullable()->comment("作品");
            $table->json("award_list")->nullable()->comment("获奖");
            $table->json("language_list")->nullable()->comment("语言能力");
            $table->json("sns_list")->nullable()->comment("社交账号");
            $table->text("self_evaluation")->nullable()->comment("自我评价");
            $table->string('creator_id',255)->default('')->comment("创建人id");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->index('position_id');
            $table->index('mobile');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talents');
    }
};
