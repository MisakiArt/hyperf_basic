<?php
declare(strict_types=1);

namespace App\Controller;

use App\Annotation\JwtIgnore;
use App\Model\User;
use App\Services\UserService;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface  as Psr7ResponseInterface;
use Qbhy\HyperfAuth\AuthManager;
use Hyperf\HttpServer\Contract\ResponseInterface;
use function Hyperf\Support\make;

/**
 * @Controller
 * Class IndexController
 */
class UserController extends AbstractController
{
    #[Inject]
    protected AuthManager $auth;

    /**
     * @return array
     */
    #[JwtIgnore]
    public function login(ResponseInterface $response) :Psr7ResponseInterface
    {
        /** @var User $user */
        $user = User::where(['id' => 1])->first();
        $user->toArray();
        $jwt = $this->auth->guard('jwt')->login($user);
//        return $this->response([ 'jwt' => $this->auth->guard('jwt')->login($user)]);
        return $this->response(compact('user', 'jwt'));
    }



    public function logout(ResponseInterface $response)  :Psr7ResponseInterface
    {
        $this->auth->guard('jwt')->logout();
        return $this->response(['logout' => 1]);
    }


    public function user(ResponseInterface $response)  :Psr7ResponseInterface
    {
        $user = $this->auth->guard('jwt')->user();
        $user = $user->toArray();
        return $this->response($user);
    }
}