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
        Schema::create('company_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->default('')->comment("名称");
            $table->string('phone', 50)->default('')->comment("手机");
            $table->string('address', 255)->default('')->comment("地址");
            $table->string('city', 50)->default('')->comment("城市");
            $table->timestamp("created_at")->useCurrent()->comment("创建时间");
            $table->timestamp("updated_at")->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment("更新时间");
            $table->timestamp("deleted_at")->nullable()->default(null)->comment("删除时间");
            $table->comment("公司信息");
        });
        Db::table('company_info')->insert([
            [
                "name"=>"武汉指南者来飞教育科技有限公司",
                "phone"=>"027-87838388",
                "address"=>"武汉市武昌区武珞路456号新时代商务中心3楼310室",
                "city"=>"武汉市"
            ],
            [
                "name"=>"常州指南者教育咨询有限公司",
                "phone"=>"0519-85600327",
                "address"=>"江苏省常州市天宁区关河东路66号九洲环宇大厦C座4楼",
                "city"=>"常州市"
            ],
            [
                "name"=>"北京指南者前程教育科技有限公司",
                "phone"=>"010-62568280",
                "address"=>"北京市海淀区中关村大街32号和盛大厦723",
                "city"=>"北京市"
            ],
            [
                "name"=>"南京指南者前程教育科技有限公司",
                "phone"=>"025-86755442",
                "address"=>"江苏省南京市玄武区洪武北路16号汇金大厦13楼",
                "city"=>"南京市"
            ],
            [
                "name"=>"广州指南者教育科技有限公司",
                "phone"=>"020-85162035",
                "address"=>"广东省广州市天河区林和西路9号耀中广场B座3807室",
                "city"=>"广州市"
            ],
            [
                "name"=>"上海指南者来飞教育科技有限公司",
                "phone"=>"021-52550609",
                "address"=>"上海市长宁区宣化路28号舜元企业发展大厦B座1007室",
                "city"=>"上海市"

            ],
            [
                "name"=>"成都指南者教育咨询有限公司",
                "phone"=>"028-61333979",
                "address"=>"成都市锦江区春熙路利都广场A座705",
                "city"=>"成都市"
            ],
        ]);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_info');
    }
};
