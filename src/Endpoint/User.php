<?php

declare(strict_types=1);

namespace Dakword\WBWebAPI\Endpoint;

use Dakword\WBWebAPI\Endpoint\AbstractEndpoint;

class User extends AbstractEndpoint
{

    /**
     * Персональные предложения для пользователя
     * 
     * @param int $userId
     * @return array
     */
    public function persGoods(int $userId = 0): array
    {
        return $this->request('https://main-page.wildberries.ru/api/v1/pers-goods', [
            'userID' => $userId
        ]);
    }

    public function xInfo()
    {
        return $this->request('https://www.wildberries.ru/webapi/user/get-xinfo-v2', [], 'POST', [
            'x-requested-with' => 'XMLHttpRequest',
        ]);
    }

    public function setUserLoc(string $address, float $latitude, float $longitude): array
    {
        $this->request('https://www.wildberries.ru/webapi/geo/saveprefereduserloc', [
            'address' => $address,
            'longitude' => $longitude,
            'latitude' => $latitude,
            ], 'FORM', [
            'x-requested-with' => 'XMLHttpRequest'
        ]);
        $headers = $this->responseHeaders();
        $cookies = [];
        foreach ($headers['Set-Cookie'] ?? [] as $item) {
            $vars = explode(';', $item);
            list($name, $value) = explode('=', $vars[0]);
            $cookies[$name] = urldecode($value);
        }

        return $cookies;
    }

}
