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
        $service = \Hyperf\Support\make(\App\Services\FeiShuService::class);
        $res = $service->getAllJobType();
        $this->insertDictionaryRecursive($res);
        $model = \App\Model\Dictionary::insertDictionary(0,"process_type","1","社招",1,'integer',"");
        $model2 =\App\Model\Dictionary::insertDictionary(0,"process_type","2","校招",2,'integer',"");
        \App\Model\Dictionary::insertDictionary($model->id,"process_type:1","101","社招-全职",1,'integer',"");
        \App\Model\Dictionary::insertDictionary($model->id,"process_type:1","102","社招-外包 - 港澳居民居住证",1,'integer',"");
        \App\Model\Dictionary::insertDictionary($model->id,"process_type:1","103","社招-劳务",1,'integer',"");
        \App\Model\Dictionary::insertDictionary($model->id,"process_type:1","105","社招-顾问",1,'integer',"");
        \App\Model\Dictionary::insertDictionary($model->id,"process_type:1","301","社招-实习",1,'integer',"");
        \App\Model\Dictionary::insertDictionary($model2->id,"process_type:2","201","校招-正式",1,'integer',"");
        \App\Model\Dictionary::insertDictionary($model2->id,"process_type:2","202","校招-实习",1,'integer',"");



    }

    function insertDictionaryRecursive($items, $parentId = 0, $parentType = "job_type") {
        foreach ($items as $item) {
            // 插入当前节点
            $current = \App\Model\Dictionary::insertDictionary(
                $parentId,
                $parentType,
                $item['id'],
                $item['name']['zh_cn'] ?? "",
                0,
                'string',
                ""
            );

            // 递归处理子节点
            if (!empty($item['children'])) {
                $this->insertDictionaryRecursive($item['children'], $current->id, "job_type:{$item['id']}");
            }
        }
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
