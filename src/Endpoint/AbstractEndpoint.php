<?php

declare(strict_types=1);

namespace Dakword\WBWebAPI\Endpoint;

use Dakword\WBWebAPI\Client;
use Dakword\WBWebAPI\Setup;

abstract class AbstractEndpoint
{
    private Client $Client;
    protected Setup $Setup;

    function __construct(Setup $user, Client $client)
    {
        $this->Client = $client;
        $this->Setup = $user;
    }

    protected function request(string $url, array $data = [], string $method = 'GET', array $addonHeaders = [])
    {
        return $this->Client->request($url, $data, $method, $addonHeaders);
    }

    public function responseCode()
    {
        return $this->Client->responseCode;
    }

    public function responsePhrase()
    {
        return $this->Client->responsePhrase;
    }

    public function responseHeaders()
    {
        return $this->Client->responseHeaders;
    }

    public function rawResponse()
    {
        return $this->Client->rawResponse;
    }

    public function response()
    {
        return $this->Client->response;
    }

    public function requestPath()
    {
        return $this->Client->requestPath;
    }

}
