<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use App\Model\Dictionary;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Dictionary::insertDictionary(0,"degree","1","小学",0,'integer',"学历");
        Dictionary::insertDictionary(0,"degree","2","初中",1,'integer',"学历");
        Dictionary::insertDictionary(0,"degree","3","专职",2,'integer',"学历");
        Dictionary::insertDictionary(0,"degree","4","高中",3,'integer',"学历");
       Dictionary::insertDictionary(0,"degree","5","大专",4,'integer',"学历");
        Dictionary::insertDictionary(0,"degree","6","本科",5,'integer',"学历");
        Dictionary::insertDictionary(0,"degree","7","硕士",6,'integer',"学历");
        Dictionary::insertDictionary(0,"degree","8","博士",7,'integer',"学历");
        Dictionary::insertDictionary(0,"education_type","1","海外及港台",0,'integer',"教育经历学历类型");
        Dictionary::insertDictionary(0,"education_type","2","统招全日制",1,'integer',"教育经历学历类型");
        Dictionary::insertDictionary(0,"education_type","3","非全日制",2,'integer',"教育经历学历类型");
        Dictionary::insertDictionary(0,"education_type","4","自考",3,'integer',"教育经历学历类型");
        Dictionary::insertDictionary(0,"education_type","5","其他",4,'integer',"教育经历学历类型");
        $model = Dictionary::insertDictionary(0,"talent_source","10000","内推",1,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10000","36","内推",1,'string',"简历来源");

        $model = Dictionary::insertDictionary(0,"talent_source","10002","内部来源",2,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10002","43","人才库",1,'string',"简历来源");

        $model = Dictionary::insertDictionary(0,"talent_source","10003","第三方招聘网站",3,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","2","智联招聘",1,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","3","前程无忧",2,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","4","猎聘",3,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","5","拉勾",4,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","18","BOSS直聘",5,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","6","领英",6,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","21","脉脉",7,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","9","应届生网",8,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","10","实习僧",9,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","44","58 同城",10,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","67","赶集网",11,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","100031","中国汽车人才网",12,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","100032","丁香人才网",13,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","100033","牛客优聘",14,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10003","20240904","海投网",15,'string',"简历来源");

        $model = Dictionary::insertDictionary(0,"talent_source","10005","线下来源",4,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10005","100000","招聘会",1,'string',"简历来源");


        $model = Dictionary::insertDictionary(0,"talent_source","10006","其他",5,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10006","100001","其它",1,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10006","7353915378877827378","小红书",1,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10006","7358690064182642994","hr小红书",2,'string',"简历来源");


        $model = Dictionary::insertDictionary(0,"talent_source","10007","外部推荐",6,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:10007","180","外部推荐",1,'string',"简历来源");

        $model = Dictionary::insertDictionary(0,"talent_source","20220531","员工转岗",7,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:20220531","202205312","外包转正式",1,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:20220531","202205311","正式员工转岗",2,'string',"简历来源");

        $model = Dictionary::insertDictionary(0,"talent_source","20220601","实习生转正",8,'string',"简历来源");
        Dictionary::insertDictionary($model->id,"talent_source:20220601","202206011","实习生转正",1,'string',"简历来源");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
