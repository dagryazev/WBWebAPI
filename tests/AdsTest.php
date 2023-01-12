<?php

namespace Dakword\WBWebAPI\Tests;

use Dakword\WBWebAPI\Tests\TestCase;

class AdsTest extends TestCase
{

    public function test_inCatalog(): void
    {
        $Ads = $this->Ads();
        $result = $Ads->inCatalog(9492);

        $this->assertIsObject($result, $Ads->requestPath());
        $this->assertObjectHasAttribute('adverts', $result, $Ads->requestPath());
    }

    public function test_inSearch(): void
    {
        $Ads = $this->Ads();
        $result = $Ads->inSearch('умный дом');

        $this->assertIsObject($result, $Ads->requestPath());
        $this->assertObjectHasAttribute('adverts', $result, $Ads->requestPath());
    }

    public function test_productCarousel(): void
    {
        $Ads = $this->Ads();
        $nmId = $this->randomNmId();

        $result = $Ads->productCarousel($nmId);
        $this->assertIsArray($result, $Ads->requestPath());
        if($result) {
            $first = array_pop($result);
            $this->assertObjectHasAttribute('position', $first, $Ads->requestPath());
        }
    }


}
