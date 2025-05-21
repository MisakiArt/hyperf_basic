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
        Schema::table('offers', function (Blueprint $table) {
            $table->json("offer_refuse_reason")->nullable()->comment("拒绝offer理由");
            $table->string("offer_refuse_other_reason")->default("")->comment("拒绝offer补充说明");
            $table->string("offer_send_time")->default("")->comment("offer发送时间");
            //
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
