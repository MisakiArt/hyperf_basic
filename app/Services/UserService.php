<?php
namespace App\Services;
use App\Repositories\UserRepository;
use App\Tools\Helper;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Listener\DeleteListenerEvent;
use Hyperf\Database\Model\Builder;
use Hyperf\Di\Annotation\Inject;
use Psr\EventDispatcher\EventDispatcherInterface;
use function Hyperf\Support\make;

class UserService extends Service
{

    #[Inject]
    protected EventDispatcherInterface $dispatcher;
    #[Inject]
    protected DepartmentService $departmentService;

    const CACHE_DELETE_EVENT = 'user_update';


    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }







}