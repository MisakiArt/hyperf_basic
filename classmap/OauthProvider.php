<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Fan\Feishu\Oauth;

use App\Libraries\feishu\Oauth\Oauth;
use Fan\Feishu\AccessToken\AppAccessToken;
use Fan\Feishu\AccessToken\TenantAccessToken;
use Fan\Feishu\Config\Config;
use Fan\Feishu\Http\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use function Hyperf\Config\config;

class OauthProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple[Oauth::getName()] = fn () => new Oauth(
            $pimple[Client::getName()],
            $pimple[AppAccessToken::getName()],
            $pimple[Config::getName()],
        );
    }
}
