<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;
use App\Model\Dictionary;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
//        Schema::table('offers', function (Blueprint $table) {
//            $table->tinyInteger('status')->default(1)->comment("offer状态 1已创建 2审批已撤回 3审批中 4审批通过 5不通过");
//        });
//        return;

        Dictionary::insertDictionary(0,"offer_type","1","正式",0,'integer',"人员类型");
        Dictionary::insertDictionary(0,"offer_type","2","实习",1,'integer',"人员类型");
        Dictionary::insertDictionary(0,"offer_type","3","外包",2,'integer',"人员类型");
        Dictionary::insertDictionary(0,"offer_type","4","劳务",3,'integer',"人员类型");
        Dictionary::insertDictionary(0,"offer_type","5","顾问",3,'integer',"人员类型");
        Schema::create('offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('talent_id')->default(0)->comment("人才id");
            $table->integer('relation_id')->default(0)->comment("关联id");
            $table->string('department',255)->default("")->comment("部门id");
            $table->string('superior_id',255)->default("")->comment("直属上级id");
            $table->integer('offer_type')->default(0)->comment("人员类型 1:正式 2:实习 3:外包 4:劳务 5:顾问");
            $table->integer('probation_period')->default(0)->comment("试用期 单位月");
            $table->string('join_time')->default("")->comment("预计入职日期");
            $table->integer('work_place')->default(1)->comment("工作地点");
            $table->string('charger')->default("")->comment("offer负责人");
            $table->string('recommendation')->default("")->comment("推荐语");
            $table->string('file')->default("")->comment("附件地址");
            $table->string('currency')->default("CNY-中国人民币")->comment("币种");
            $table->string('pay_type')->default("月薪")->comment("月薪|日新");
            $table->integer('pay')->default(0)->comment("基本薪资");
            $table->integer('probation_percent')->default(0)->comment("试用期薪资百分比");
            $table->integer('housing_subsidy')->default(0)->comment("住房补贴");
            $table->json('approve_users')->comment("审批人");
            $table->json('recipient_users')->comment("抄送人");
            $table->integer('recipient_type')->default(0)->comment("抄送类型1:审批通过后抄送 2:发起审批时抄送 3:发起和通知后均抄送");
            $table->json('approve_result')->comment("审批结果");
            $table->string('approve_initiator',255)->default("")->comment("审批发起人");
            $table->timestamp('approve_initiate_time')->nullable()->comment("审批发起时间");
            $table->tinyInteger('status')->default(1)->comment("offer状态 1已创建 2审批已撤回 3审批中 4审批通过 5不通过");
            $table->string('creator_id',255)->comment("创建人");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->comment("offer");
            $table->index('relation_id');
            $table->index('talent_id');
            $table->index('creator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
