<?php

namespace Dakword\WBWebAPI\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Dakword\WBWebAPI\WebAPI;
use Dakword\WBWebAPI\Endpoint\Ads;
use Dakword\WBWebAPI\Endpoint\Catalog;
use Dakword\WBWebAPI\Endpoint\Product;
use Dakword\WBWebAPI\Endpoint\Search;

class TestCase extends PHPUnitTestCase
{
    private $persGoods = null;

    protected function Ads(): Ads
    {
        $webAPI = new WebAPI();
        return $webAPI->Ads();
    }

    protected function Catalog(): Catalog
    {
        $webAPI = new WebAPI();
        return $webAPI->Catalog();
    }

    protected function Product(): Product
    {
        $webAPI = new WebAPI();
        return $webAPI->Product();
    }

    protected function Search(): Search
    {
        $webAPI = new WebAPI();
        return $webAPI->Search();
    }

    protected function randomNmId(): int
    {
        if (is_null($this->persGoods)) {
            $this->persGoods = $this->Catalog()->persGoods();
        }
        return $this->persGoods[array_rand($this->persGoods)];
    }

    protected function xInfo(): array
    {
        $xInfo = [];
        foreach (explode('&', $this->Catalog()->xInfo()->xinfo) as $chunk) {
            $param = explode("=", $chunk);
            if ($param) {
                $xInfo[urldecode($param[0])] = urldecode($param[1]);
            }
        }
        return $xInfo;
    }

}
