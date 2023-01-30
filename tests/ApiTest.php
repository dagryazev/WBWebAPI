<?php

namespace Dakword\WBWebAPI\Tests;

use Dakword\WBWebAPI\WebAPI;
use Dakword\WBWebAPI\Endpoint\Ads;
use Dakword\WBWebAPI\Endpoint\Catalog;
use Dakword\WBWebAPI\Endpoint\Product;
use Dakword\WBWebAPI\Endpoint\Search;
use Dakword\WBWebAPI\Endpoint\User;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{

    public function test_API(): void
    {
        $webAPI = new WebAPI();
        $this->assertInstanceOf(WebAPI::class, $webAPI);
    }

    public function test_Endpoint_Ads(): void
    {
        $webAPI = new WebAPI();
        $this->assertInstanceOf(Ads::class, $webAPI->Ads());
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

    public function test_Endpoint_Search(): void
    {
        $webAPI = new WebAPI();
        $this->assertInstanceOf(Search::class, $webAPI->Search());
    }

    public function test_Endpoint_User(): void
    {
        $webAPI = new WebAPI();
        $this->assertInstanceOf(User::class, $webAPI->User());
    }

}
