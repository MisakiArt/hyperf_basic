<?php
namespace App\Repositories;

use App\Model\User;

class UserRepository extends Repository {
    public function __construct(User $model)
    {
        $this->model = $model;
    }



    public function getInfoByUserId($userId): array
    {
        return $this->getQuery()->where(['user_id'=>$userId])->first()?->toArray();


    }


}