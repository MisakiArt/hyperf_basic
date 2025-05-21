<?php
namespace App\Repositories;

use App\Model\Model;
use App\Tools\Log;

abstract class Repository {

    /**
     * @var  Model $model
     */
    protected Model $model;

    /**
     * 获取所有记录
     *
     * @return array
     */
    public function getByCondition($condition,$column = ["*"]): array
    {
        return $this->getQuery()->where($condition)->get($column)->toArray();
    }

    /**
     * 根据 ID 获取单条记录
     *
     * @param int $id
     * @return array
     */
    public function getById(int $id,bool $cache = true): array
    {
        if ($cache) {
            $item = $this->model->findFromCache($id);
        } else {
            $item = $this->getQuery()->where([$this->model->getKeyName()=>$id])->first();
        }
        return  $item ? $item->toArray(): [];
    }


    public function batchGetByIds(array $ids): array
    {
        $models  = $this->model->findManyFromCache($ids);
        return !empty($models) ? $models->toArray() : [];
    }

    /**
     * 创建新记录
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data,$with = []): Model
    {
        $model = clone $this->model;
        $model->fill($data);
        $model->save();
        $model->refresh();
        if (!empty($with)) {
            $model->load($with);
        }

        return $model;
    }

    /**
     * 更新记录
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data,$with = []): Model
    {
        $model = $this->model->find($id);
        $model->fill($data);
        $model->save();
        if (!empty($with)) {
            $model->load($with);
        }
        return $model;
    }

    /**
     * 删除记录
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $model = $this->model->find($id);
        if (empty($model))  return true;
        try {
            $model->delete();
        } catch (\Exception $ex) {
            Log::get()->error($ex->getMessage());
            return  false;
        }
        return true;
    }


    /**
     * 批量插入
     * @param array $data
     * @return void
     */
    public function batchInsert(array $data): void
    {
        $this->model->insert($data);
    }


    /**
     * 不存在则新建
     * @param array $where
     * @param array $data
     * @return Model
     */
    public function firstOrCreate(array $where, array $data): Model
    {
        return $this->model->firstOrCreate($where, $data);
    }


    /**
     * 新建或更新
     * @param array $where
     * @param array $data
     * @return Model
     */
    public function updateOrCreate(array $where, array $data): Model
    {
        return $this->model->updateOrCreate($where, $data);
    }

    public function paginate($page=1,$pageSize=20,$column = ['*'],$where = [])
    {
        return $this->model->query()->where($where)->paginate($pageSize,$column,'page',$page);

    }


    public function getQuery()
    {
        return $this->model->newQuery();
    }


    public function getAllFields()
    {
        return $this->model->getAllowedFields();
    }

}