<?php

namespace Dakword\WBWebAPI\Tests;

use Dakword\WBWebAPI\WebAPI;
use Dakword\WBWebAPI\Endpoint\Catalog;
use Dakword\WBWebAPI\Endpoint\Product;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{

    public function test_API(): void
    {
        $webAPI = new WebAPI();
        $this->assertInstanceOf(WebAPI::class, $webAPI);
    }

    public function test_Endpoint_Catalog(): void
    {
        $webAPI = new WebAPI();
        $this->assertInstanceOf(Catalog::class, $webAPI->Catalog());
    }

    public function test_Endpoint_Product(): void
    {
        $webAPI = new WebAPI();
        $this->assertInstanceOf(Product::class, $webAPI->Product());
    }

}
