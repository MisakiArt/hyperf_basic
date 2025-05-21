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
        Schema::create('dictionary', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id')->default(0)->comment("父id");
            $table->string('type',100)->default("")->comment("字典类型，如gender、status");
            $table->string('code',50)->default("")->comment("字典编码");
            $table->string('value',255)->default("")->comment("字典显示");
            $table->integer('sort')->default(0)->comment("排序字段");
            $table->string('remark')->default("")->comment("备注");
            $table->string('code_type')->default("string")->comment("code类型 integer|string");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->unique(['type', 'code']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictionary');
    }
};
