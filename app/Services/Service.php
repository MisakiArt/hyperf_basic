<?php
namespace App\Services;
use App\Repositories\Repository;
use App\Traits\HttpRequestTrait;
use App\Traits\ListQueryTrait;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\ClientFactory;
use Psr\Http\Message\ResponseInterface;

/**
 * Service基类
 * @mixin Repository
 *
 */
class Service
{
    use ListQueryTrait;
    use HttpRequestTrait;

    /**
     * @var Repository $repository 
     */
    protected Repository $repository;




    public function getAllowedFields(): array
    {
        return $this->repository->getAllFields();
    }


    /**
     * 创建
     * @param array $data
     * @param array $with
     * @return array
     */
    public function create(array $data,array $with = []): array
    {
        $model = $this->repository->create($data,$with);
        return $model->toArray();
    }

    /**
     * 更新
     * @param $id
     * @param array $data
     * @param array $with
     * @return array
     */
    public function update($id, array $data, array $with = []): array
    {
        $model = $this->repository->update($id,$data,$with);
        return $model->toArray();
    }

    /**
     * 删除
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        $data = $this->repository->getById($id);
        $this->repository->delete($id);
        $this->afterDelete($data);
    }


    public function afterDelete($data): void
    {
    }



    public function firstOrCreate(array $condition, array $data): array
    {
        $model =  $this->repository->firstOrCreate($condition, $data);
        return !empty($model) ? $model->toArray() :[];
    }

    public function updateOrCreate(array $condition, array $data): array
    {
        $model =  $this->repository->updateOrCreate($condition, $data);
        return !empty($model) ? $model->toArray() :[];
    }


    //基础查询不满足要求可以重写此方法
    public function getIndexQuery($params): \Hyperf\Database\Model\Builder
    {
        return $this->repository->getQuery();
    }

    //基础查询不满足要求可以重写此方法
    public function getListQuery($params): \Hyperf\Database\Model\Builder
    {
        return $this->repository->getQuery();
    }


    public function index($params,$columns = ["*"],$with = []): array
    {
        $columns = !empty($params['fields']) ? $params['fields'] : $columns;
        $paginate =  $this->applyListPaginate($this->getIndexQuery($params)->with($with), $params,$columns);
        $res =  [
            'current_page'=>$paginate->currentPage(),
            'per_page'=>$paginate->perPage(),
            'total'=>$paginate->total(),
            'data' => $paginate->getCollection()->toArray(),
        ];
        return $this->transFormIndex($res);
    }


    public function getList($params,$columns = ["*"],$with = []): array
    {
        $columns = !empty($params['fields']) ? $params['fields'] : $columns;
        $list = $this->applyListAll($this->getListQuery($params)->with($with), $params,$columns);

        return $list->toArray();
    }



    public function getDetail($id,$with = []) :array
    {
        $result = $this->repository->getQuery()->with($with)->where(['id'=>$id])->first();
        if (empty($result)) return [];
        $result = $result->toArray();
        return $this->transformDetail($result);
    }



    //不满足要求时重写此方法
    public function transformDetail($result) :array
    {
        $result = (array)$result;
        return  $result;
    }

    public function transFormIndex($result):array
    {
        return (array)$result;
    }

    public function __call($method, $parameters)
    {
        if (method_exists($this->repository, $method)) {
            return $this->repository->$method(...$parameters);
        } else {
            throw new \BadMethodCallException(sprintf("function '%s' does not exist.", $method));
        }
    }
}