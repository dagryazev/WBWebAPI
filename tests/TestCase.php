<?php

namespace Dakword\WBWebAPI\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Dakword\WBWebAPI\WebAPI;
use Dakword\WBWebAPI\Setup;
use Dakword\WBWebAPI\Endpoint\Ads;
use Dakword\WBWebAPI\Endpoint\Catalog;
use Dakword\WBWebAPI\Endpoint\Product;
use Dakword\WBWebAPI\Endpoint\Search;
use Dakword\WBWebAPI\Endpoint\User;

class TestCase extends PHPUnitTestCase
{
    private $persGoods = null;

    protected function webApi(): WebAPI
    {
        return new WebAPI();
    }

    protected function Ads(): Ads
    {
        return $this->webAPI()->Ads();
    }

    protected function Catalog(): Catalog
    {
        return $this->webAPI()->Catalog();
    }

    protected function Product(): Product
    {
        return $this->webAPI()->Product();
    }

    protected function Search(): Search
    {
        return $this->webAPI()->Search();
    }

    protected function User(): User
    {
        return $this->webAPI()->User();
    }

    protected function randomNmId(): int
    {
        if (is_null($this->persGoods)) {
            $this->persGoods = $this->User()->persGoods();
        }
        return $this->persGoods[array_rand($this->persGoods)];
    }

    protected function xInfo(): array
    {
        $xInfo = [];
        foreach (explode('&', $this->User()->xInfo()->xinfo) as $chunk) {
            $param = explode("=", $chunk);
            if ($param) {
                $xInfo[urldecode($param[0])] = urldecode($param[1]);
            }
        }
        return $xInfo;
    }

    protected function fillSetupByXinfo(Setup $Setup): void
    {
        $xInfo = $this->xInfo();

        $Setup->setRegions(explode(',', $xInfo['regions']));
        $Setup->setDest(explode(',', $xInfo['dest']));
        $Setup->setCouponsGeo(explode(',', $xInfo['couponsGeo']??''));
    }

}
