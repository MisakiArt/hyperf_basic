<?php

declare(strict_types=1);

namespace App\Traits;

use Hyperf\Database\Model\Builder;
use Hyperf\HttpServer\Contract\RequestInterface;
use function Hyperf\Coroutine\co;

trait ListQueryTrait
{

    abstract public function getAllowedFields(): array;

    /**
     * 通用列表查询
     */
    public function applyListPaginate(Builder $query, $params, $column = ["*"])
    {
        $allowedFields = $this->getAllowedFields();
        $this->buildQuery($query, $params, $allowedFields);
        $allowedFields[] = "*";
        $column = array_intersect($allowedFields, $column);
        $column = array_map(function ($value) use ($query) {
            if ($value != "*") {
                $value = $query->getModel()->getTable() . "." . $value;
            }
            return $value;
        },$column);
        // 分页
        $page = (int)($params['page'] ?? 1);
        $pageSize = (int)($params['page_size'] ?? 20);
        return $query->paginate($pageSize, $column, 'page', $page);
    }


    public function applyListAll(Builder $query, $params, $column = ["*"])
    {
        $allowedFields = $this->getAllowedFields();
        $this->buildQuery($query, $params, $allowedFields);
        $allowedFields[] = "*";
        $column = array_intersect($allowedFields, $column);
        $column = array_map(function ($value) use ($query) {
            if ($value != "*") {
                $value = $query->getModel()->getTable() . "." . $value;
            }
            return $value;
        },$column);
        return $query->get($column);

    }


    public function getFieldName(Builder $query,$field)
    {
        if (!str_contains($field, ".")) {
            return $query->getModel()->getTable().'.'.$field;
        }
        return $field;
    }


    public function buildQuery(Builder $query, $params, $allowedFields = [])
    {
        if ($filters = $params['filters'] ?? []) {
            foreach ($filters as $field => $value) {
                if (strpos((string)$field, 'range_') !== false && is_array($value) && count($value) === 2) {
                    $query->whereBetween(str_replace('range_', '', $field), $value);
                    continue;
                }
                if (!in_array($field, $allowedFields)) continue;
                if (is_string($value) || is_numeric($value)) {
                    if ($value !== "") {
                        $query->where($this->getFieldName($query,$field), '=', $value);
                    }
                    continue;
                }


                if (is_array($value) && $this->isAssocArray($value)) {
                    foreach ($value as $k => $v) {
                        switch ($k) {
                            case "=":
                                $query->where($this->getFieldName($query,$field), $v);
                                break;
                            case "like":
                                $query->where($this->getFieldName($query,$field), 'like', "%$v%");
                                break;
                            case "in":
                                $query->whereIn($this->getFieldName($query,$field), $v);
                                break;
                            case "between":
                                $query->whereBetween($this->getFieldName($query,$field), $v);
                                break;
                        }
                    }
                    continue;
                }
                if (is_array($value) && !empty($value)) {
                    $query->whereIn($this->getFieldName($query,$field), $value);
                }
            }

        }

        if ($sortFields = $params['sortFields'] ?? []) {
            foreach ($sortFields as $sort) {
                if (!empty($sort['field'])  && !empty($sort['order']) && in_array($sort['order'], ['asc', 'desc'])) {
                    if (!in_array($sort['field'], $allowedFields)) continue;
                    $query->orderBy($this->getFieldName($query,$sort['field']), $sort['order']);
                }
            }
        } else {
            $query->orderBy($this->getFieldName($query,'created_at'), 'desc');
        }

    }

    function isAssocArray(array $arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }


    public function buildQueryOld(Builder $query, $params)
    {
        $allowedFields = $this->getAllowedFields();
        // 过滤条件
        if ($filters = $params['filters'] ?? []) {
            foreach ($filters as $filter) {
                if (!empty($filter['field']) && isset($filter['value'])) {
                    if (!in_array($filter['field'], $allowedFields)) continue;

                    if (!empty($filter['operator'])) {
                        switch ($filter['operator']) {
                            case "=":
                                $query->where($filter['field'], $filter['value']);
                                break;
                            case "like":
                                $query->where($filter['field'], 'like', '%' . $filter['value'] . '%');
                                break;
                            case "in":
                                $query->whereIn($filter['field'], $filter['value']);
                                break;
                            case "between":
                                $query->whereBetween($filter['field'], $filter['value']);
                                break;
                        }
                    } else {
                        $query->where($filter['field'], $filter['value']);
                    }
                }
            }
        }

        // 排序
        if ($sortFields = $params['sortFields'] ?? []) {
            foreach ($sortFields as $sort) {
                if (!empty($sort['field']) && in_array($sort['order'], ['asc', 'desc'])) {
                    if (!in_array($sort['field'], $allowedFields)) continue;
                    $query->orderBy($sort['field'], $sort['order']);
                }
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
    }
}
