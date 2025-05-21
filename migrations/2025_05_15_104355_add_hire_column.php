<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hires', function (Blueprint $table) {
            $table->string("email")->default("")->comment("邮箱");
            $table->tinyInteger("offer_type")->default(0)->comment("人员类型 1:正式 2:实习 3:外包 4:劳务 5:顾问");
            $table->string("department")->default("")->comment("部门");
            $table->string("job_title")->default("")->comment("职位title");
            $table->string("superior_id")->default("")->comment("直属上级");
            $table->integer("address_id")->default(0)->comment("地点");
            $table->string("talent_source")->default("")->comment("简历来源");
            $table->index('created_at');
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
