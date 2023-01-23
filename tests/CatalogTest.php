<?php

namespace Dakword\WBWebAPI\Tests;

use Dakword\WBWebAPI\Tests\TestCase;

class CatalogTest extends TestCase
{

    public function test_mainMenu(): void
    {
        $Catalog = $this->Catalog();
        $result = $Catalog->mainMenu();
        $this->assertIsArray($result, $Catalog->requestPath());
        $first = array_shift($result);
        $this->assertObjectHasAttribute('id', $first);
        $this->assertObjectHasAttribute('name', $first);
        $this->assertObjectHasAttribute('url', $first);
        $this->assertObjectHasAttribute('childs', $first);
    }

    public function test_persGoods(): void
    {
        $Catalog = $this->Catalog();
        $result = $Catalog->persGoods();
        $this->assertIsArray($result, $Catalog->requestPath());
    }

    public function test_supplierInfo(): void
    {
        $nmId = $this->randomNmId();
        $card = $this->Product()->card($nmId);
        $supplierId = $card->selling->supplier_id;

        $Catalog = $this->Catalog();
        $result = $Catalog->supplierInfo($supplierId);

        $this->assertEquals($supplierId, $result->id, $Catalog->requestPath());
    }

    public function test_suppliersByIds(): void
    {
        $nmId = $this->randomNmId();
        $card = $this->Product()->card($nmId);
        $supplierId = $card->selling->supplier_id;

        $Catalog = $this->Catalog();
        $result = $Catalog->suppliersByIds([$supplierId]);

        $this->assertTrue(in_array($supplierId, array_column($result, 'id')));
    }

    public function test_brandById(): void
    {
        $Catalog = $this->Catalog();
        $result = $Catalog->brandById(21);
        
        $this->assertEquals(21, $result->id, $Catalog->requestPath());
    }

    public function test_brandByName(): void
    {
        $Catalog = $this->Catalog();
        $result = $Catalog->brandByName('adidas');
        
        $this->assertEquals(21, $result->id, $Catalog->requestPath());
    }

    public function test_brandVotesById(): void
    {
        $Catalog = $this->Catalog();
        $result = $Catalog->brandVotesById(21);

        $this->assertEquals(0, $result->resultState, $Catalog->requestPath());
        $this->assertObjectHasAttribute('votesCount', $result->value, $Catalog->requestPath());
    }

    public function test_allPoo(): void
    {
        $Catalog = $this->Catalog();
        $result = $Catalog->allPoo();

        $this->assertIsArray($result, $Catalog->requestPath());
        $this->assertTrue(in_array('ru', array_column($result, 'country')));
    }

    public function test_pooByIds(): void
    {
        $Catalog = $this->Catalog();
        $result = $Catalog->pooByIds([1]);

        $this->assertEquals(0, $result->resultState, $Catalog->requestPath());
        $this->assertObjectHasAttribute('value', $result, $Catalog->requestPath());
    }

    public function test_xInfo(): void
    {
        $Catalog = $this->Catalog();
        $result = $Catalog->xInfo();

        $this->assertObjectHasAttribute('xinfo', $result, $Catalog->requestPath());
        $this->assertObjectHasAttribute('shard', $result, $Catalog->requestPath());
    }

    public function test_expressStore(): void
    {
        $Catalog = $this->Catalog();
        $result = $Catalog->expressStore('55,2258852', '37,7993833');

        $this->assertEquals(0, $result->resultState, $Catalog->requestPath());
        $this->assertObjectHasAttribute('value', $result, $Catalog->requestPath());
    }

    public function test_brandsList(): void
    {
        $Catalog = $this->Catalog();
        $result = $Catalog->brandsList('a');
        $this->assertEquals(0, $result->resultState, $Catalog->requestPath());
        $this->assertObjectHasAttribute('brandsCount', $result->value, $Catalog->requestPath());
        $this->assertObjectHasAttribute('brandsList', $result->value, $Catalog->requestPath());
    }

    public function test_catalog(): void
    {
        $xInfo = $this->xInfo();
        $Catalog = $this->Catalog();

        $result = $Catalog->catalog('electronic14', [], 1, [846, 6240], explode(',', $xInfo['regions']), explode(',', $xInfo['dest']), couponsGeo: explode(',', $xInfo['couponsGeo']));

        $this->assertEquals(0, $result->state, $Catalog->requestPath());
        $this->assertObjectHasAttribute('products', $result->data, $Catalog->requestPath());
        $this->assertIsArray($result->data->products, $Catalog->requestPath());
    }

    public function test_filter(): void
    {
        $xInfo = $this->xInfo();
        $Catalog = $this->Catalog();

        $result = $Catalog->filter('electronic14', [], 1, [846, 6240], explode(',', $xInfo['regions']), explode(',', $xInfo['dest']), couponsGeo: explode(',', $xInfo['couponsGeo']));

        $this->assertEquals(0, $result->state, $Catalog->requestPath());
        $this->assertObjectHasAttribute('filters', $result->data, $Catalog->requestPath());
        $this->assertIsArray($result->data->filters, $Catalog->requestPath());
    }

    public function test_subjects(): void
    {
        $Catalog = $this->Catalog();

        $result = $Catalog->subjects();

        $this->assertIsArray($result, $Catalog->requestPath());
        
        $first = array_pop($result);
        
        $this->assertObjectHasAttribute('id', $first, $Catalog->requestPath());
        $this->assertObjectHasAttribute('name', $first, $Catalog->requestPath());
        $this->assertObjectHasAttribute('url', $first, $Catalog->requestPath());
        $this->assertObjectHasAttribute('childs', $first, $Catalog->requestPath());
    }

    public function test_setUserLoc(): void
    {
        $Catalog = $this->Catalog();

        $result = $Catalog->setUserLoc('г Краснодар, Улица Ленина 50', 45.023, 38.97358);

        $this->assertArrayHasKey('__region', $result, $Catalog->requestPath());
        $this->assertArrayHasKey('__dst', $result, $Catalog->requestPath());
    }

}
