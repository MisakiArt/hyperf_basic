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
        Schema::create('offer_send_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("offer_id")->default(0)->comment("offer id");
            $table->string("file_name")->default("")->comment("文件名");
            $table->string("file_path")->default("")->comment("文件路径");
            $table->tinyInteger("status")->default(0)->comment("状态");
            $table->string("expire_date")->default("")->comment("失效时间");
            $table->string("send_email")->default("")->comment("发送人邮箱");
            $table->string("send_mobile")->default("")->comment("发送人手机号");
            $table->string("refuse_reason")->default("")->comment("拒绝原因");
            $table->string("offer_refuse_other_reason")->default("")->comment("拒绝offer补充说明");
            $table->integer("file_template_id")->default(0)->comment("offer 模板id");
            $table->string('creator_id',255)->default("")->comment("创建人");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->comment("offer发送记录");
            $table->index("created_at");
            $table->index("offer_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_send_records');
    }
};
