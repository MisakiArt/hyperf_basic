<?php

declare(strict_types=1);

namespace App\Model;



use Hyperf\Database\Model\SoftDeletes;
use Hyperf\ModelCache\Cacheable;
use Qbhy\HyperfAuth\Authenticatable;

/**
 * @property int $id 
 * @property string $union_id 
 * @property string $user_id 
 * @property string $open_id 
 * @property string $name 
 * @property string $en_name 
 * @property string $nickname 
 * @property string $email 
 * @property string $mobile 
 * @property int $mobile_visible 
 * @property int $gender 
 * @property string $avatar 
 * @property string $department_ids 
 * @property int $is_frozen 
 * @property int $is_activated 
 * @property int $is_exited 
 * @property int $is_resigned 
 * @property int $is_unjoin 
 * @property string $leader_user_id 
 * @property string $city 
 * @property string $country 
 * @property string $work_station 
 * @property int $join_time 
 * @property int $is_tenant_manager 
 * @property string $employee_no 
 * @property int $employee_type 
 * @property string $job_title 
 * @property string $geo 
 * @property string $job_level_id 
 * @property string $job_family_id 
 * @property string $enterprise_email
 * @property string $created_at 
 * @property string $updated_at 
 * @property string $deleted_at 
 */
class User extends Model implements Authenticatable
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'users';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ["is_frozen","is_activated","is_exited","is_resigned","is_unjoin","union_id", "user_id", "open_id", "name", "en_name", "nickname", "email", "mobile", "mobile_visible", "gender", "avatar", "department_ids", "status", "leader_user_id", "city", "country", "work_station", "join_time", "is_tenant_manager", "employee_no", "employee_type", "job_title", "geo", "job_level_id", "job_family_id", "enterprise_email"];

    protected array $allow_field = ['name'];



    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'mobile_visible' => 'integer', 'gender' => 'integer', 'is_frozen' => 'integer', 'is_activated' => 'integer', 'is_exited' => 'integer', 'is_resigned' => 'integer', 'is_unjoin' => 'integer', 'join_time' => 'integer', 'is_tenant_manager' => 'integer', 'employee_type' => 'integer',
        'department_ids'=>"array",
        'avatar'=>"array",
    ];
    public bool $timestamps = false;

    public function getId()
    {
        return $this->user_id;
    }

    //todo 需要修改
    public static function retrieveById($key): ?Authenticatable
    {
        return self::query()->where(['user_id' => $key])->first();

    }


}
