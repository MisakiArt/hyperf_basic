<?php

use App\Model\Dictionary;
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
        Schema::create('action_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("object_type",50)->default("")->comment("操作对象类型");
            $table->integer("object_id")->default(0)->comment("操作对象id");
            $table->integer("action_type")->default(0)->comment("行为类型");
            $table->text("comment")->comment("备注");
            $table->json("other_info")->comment("其他相关信息");
            $table->string('creator_id',255)->comment("创建人");
            $table->integer("talent_id")->default(0)->comment("人才id");
            $table->integer("job_id")->default(0)->comment("职位");
            $table->integer("offer_id")->default(0)->comment("offer_id");
            $table->integer("interview_id")->default(0)->comment("面试id");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->index("creator_id");
            $table->index("talent_id");
            $table->index("object_id");
            $table->index("action_type");
            $table->index("created_at");
        });
//        return;


        Dictionary::insertDictionary(0,"action_type:talent","1","新建人才",0,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","2","安排评估",1,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","3","评估简历",2,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","4","修改评估结果",3,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","5","添加评估备注",4,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","6","安排面试",5,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","7","修改面试",6,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","8","取消面试",7,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","9","标记候选人未到场",8,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","10","填写面评",9,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","11","修改面试评价",10,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","12","导出面试记录",11,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","13","加入职位",12,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","14","转移投递阶段",13,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","15","新建Offer",14,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","16","编辑Offer",15,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","17","发起Offer审批",16,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","18","Offer审批通过",17,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","19","Offer审批不通过",18,'integer',"行为类型");
        Dictionary::insertDictionary(0,"action_type:talent","20","撤回Offer审批",19,'integer',"行为类型");




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_records');
    }
};
