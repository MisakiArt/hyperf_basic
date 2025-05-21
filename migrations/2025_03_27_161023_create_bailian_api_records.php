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
        Schema::create('bailian_api_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("url")->default("")->comment("url");
            $table->json('body')->comment("消息体");
            $table->json('response')->comment("返回");
            $table->integer('response_time')->comment("响应时间");
            $table->integer('response_code')->comment("响应code");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->comment("百炼api请求记录");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bailian_api_records');
    }
};
