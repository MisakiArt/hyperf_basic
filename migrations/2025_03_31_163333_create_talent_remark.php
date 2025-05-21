<?php

use App\Model\Remark;
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
        Schema::create('remark', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type',20)->default("")->comment("类型，talent|relation|job");
            $table->string('remark_type',255)->default("")->comment("备注类型");
            $table->integer("object_id")->default(0)->comment("人才id|relation_id|job_id");
            $table->integer("talent_id")->default(0)->comment("人才id");
            $table->text('remark')->comment("备注");
            $table->string('creator_id',255)->default("")->comment("创建人");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->comment("人才备注");
            $table->index('object_id');
        });





    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent_remark');
    }
};
