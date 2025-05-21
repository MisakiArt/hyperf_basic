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
        Schema::table('talents', function (Blueprint $table) {
            $table->json("registration")->comment("面试登记表信息");
            $table->string("registration_file_path")->comment("面试登记表pdf链接");
        });

        Schema::create('notification_template', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name")->default("")->comment("模板名称");
            $table->string("email_title")->default("")->comment("邮件主题");
            $table->text("email_content")->comment("邮件内容");
            $table->text("sms_content")->comment("短信内容");
            $table->integer("type")->default(0)->comment("模板类型 1:视频面试 2:现场面试 3:电话面试");
            $table->string('creator_id',255)->default("")->comment("创建人");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->comment("通知模板");
        });
//        return ;


        Schema::create('notification_send_record', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("type")->default(0)->comment("1:mobile 2:email");
            $table->string("email")->default("")->comment("邮箱");
            $table->string("mobile")->default("")->comment("手机号");
            $table->string("title")->default("")->comment("主题");
            $table->json("result")->comment("发送结果");
            $table->json("param")->comment("其他参数");
            $table->integer("interview_id")->default(0)->comment("面试id");
            $table->integer("offer_id")->default(0)->comment("offer id");
            $table->text("content")->comment("内容");
            $table->string('creator_id',255)->comment("创建人");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->comment("记录");
            $table->index("creator_id");
            $table->index("offer_id");
            $table->index("interview_id");
        });
        Schema::create('offer_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name")->default("")->comment("名称");
            $table->text("content")->comment("简历文件内容");
            $table->string('creator_id',255)->comment("创建人");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->comment("offer文件");
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->integer('offer_file_id')->default(0)->comment("offer文件id");
            $table->string('job_title')->default("")->comment("入职职位");
            $table->string('expire_date')->default("")->comment("offer失效时间");
            $table->string('join_date')->default("")->comment("预计入职时间");
            $table->integer('offer_user_approve')->default(0)->comment("offer是否被同意 0 未同意 1同意 2不同意");
        });
        Schema::table('interview_records', function (Blueprint $table) {
            $table->string("contact_user")->default("")->comment("面试联系人");
            $table->string("contact_tel")->default("")->comment("面试联系人手机号");
            $table->string("contact_email")->default("")->comment("面试联系人邮箱");
        });







    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_file');
    }
};
