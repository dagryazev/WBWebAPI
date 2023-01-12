<?php

namespace Dakword\WBWebAPI\Tests;

use Dakword\WBWebAPI\Tests\TestCase;

class SearchTest extends TestCase
{

    public function test_suggests(): void
    {
        $Search = $this->Search();
        $result = $Search->suggests('шуба');

        $this->assertIsArray($result, $Search->requestPath());
        $this->assertTrue(in_array('шуба чебурашка', array_column($result, 'name')), $Search->requestPath());
    }

    public function test_catalog(): void
    {
        $xInfo = $this->xInfo();
        $Search = $this->Search();
        $result = $Search->catalog('шуба', 1, explode(',', $xInfo['regions']), explode(',', $xInfo['dest']), 'popular', [], explode(',', $xInfo['couponsGeo']));

        $this->assertIsObject($result, $Search->requestPath());
        $this->assertEquals(0, $result->state, $Search->requestPath());
        $this->assertObjectHasAttribute('products', $result->data, $Search->requestPath());
    }

    public function test_filters(): void
    {
        $xInfo = $this->xInfo();
        $Search = $this->Search();
        $result = $Search->filters('шуба', 1, explode(',', $xInfo['regions']), explode(',', $xInfo['dest']), 'popular', [], explode(',', $xInfo['couponsGeo']));

        $this->assertIsObject($result, $Search->requestPath());
        $this->assertEquals(0, $result->state, $Search->requestPath());
        $this->assertObjectHasAttribute('filters', $result->data, $Search->requestPath());
        $this->assertEquals('шуба', $result->metadata->name, $Search->requestPath());
    }

    public function test_similarCatalogQueries(): void
    {
        $Search = $this->Search();
        $result = $Search->similarCatalogQueries('/catalog/dom-i-dacha/kuhnya/kastryuli-i-skovorody');

        $this->assertIsArray($result, $Search->requestPath());
    }

    public function test_similarQueries(): void
    {
        $xInfo = $this->xInfo();
        $Search = $this->Search();
        $result = $Search->similarQueries('шуба', explode(',', $xInfo['regions']), explode(',', $xInfo['dest']), explode(',', $xInfo['couponsGeo']));

        $this->assertIsObject($result, $Search->requestPath());
        $this->assertObjectHasAttribute('brands', $result, $Search->requestPath());
        $this->assertObjectHasAttribute('query', $result, $Search->requestPath());
    }

    public function test_recomendations(): void
    {
        $Search = $this->Search();
        $result = $Search->recomendations('шуба');

        $this->assertIsArray($result, $Search->requestPath());
    }
}
