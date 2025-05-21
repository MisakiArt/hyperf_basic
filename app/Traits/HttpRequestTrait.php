<?php

declare(strict_types=1);

namespace App\Traits;

use Hyperf\Database\Model\Builder;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function Hyperf\Coroutine\co;

trait HttpRequestTrait
{
    #[Inject]
    protected ClientFactory $clientFactory;
    public function callPost($url,$body = [],$headers = [],$timeout = 0): ResponseInterface
    {
        $options = [
            "http_errors"=>false
        ];
        if (!empty($timeout)) {
            $options["timeout"] = $timeout;
        }

        // $client 为协程化的 GuzzleHttp\Client 对象
        $client = $this->clientFactory->create($options);
        $response = $client->post(
            $url,
            [
                'headers' => $headers,
                'body'=>json_encode($body,JSON_UNESCAPED_UNICODE)
            ]
        );
        return $response;
    }

    public function request($method,$url,$body,$headers,$timeout = 0): ResponseInterface
    {
        $options = [
            "http_errors"=>false
        ];
        if (!empty($timeout)) {
            $options["timeout"] = $timeout;
        }

        // $client 为协程化的 GuzzleHttp\Client 对象
        $client = $this->clientFactory->create($options);
        $response = $client->request($method,
            $url,
            [
                'headers' => $headers,
                'body'=>json_encode($body,JSON_UNESCAPED_UNICODE)
            ]
        );
        return $response;
    }




}
