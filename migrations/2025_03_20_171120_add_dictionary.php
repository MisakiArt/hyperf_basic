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
        \App\Model\Dictionary::insertDictionary(0,"identification_type","1","中国 - 居民身份证",1,'integer',"");
        \App\Model\Dictionary::insertDictionary(0,"identification_type","2","护照",1,'integer',"");
        \App\Model\Dictionary::insertDictionary(0,"identification_type","3","中国 - 港澳居民居住证",1,'integer',"");
        \App\Model\Dictionary::insertDictionary(0,"identification_type","4","中国 - 台湾居民来往大陆通行证",1,'integer',"");
        \App\Model\Dictionary::insertDictionary(0,"identification_type","5","其他",1,'integer',"");

        \App\Model\Dictionary::insertDictionary(0,"gender","1","男",1,'integer',"");
        \App\Model\Dictionary::insertDictionary(0,"gender","2","女",2,'integer',"");
        \App\Model\Dictionary::insertDictionary(0,"gender","3","其他",3,'integer',"");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
