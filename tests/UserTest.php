<?php

namespace Dakword\WBWebAPI\Tests;

use Dakword\WBWebAPI\Tests\TestCase;

class UserTest extends TestCase
{

    public function test_persGoods(): void
    {
        $User = $this->User();
        $result = $User->persGoods();
        $this->assertIsArray($result, $User->requestPath());
    }

    public function test_xInfo(): void
    {
        $User = $this->User();
        $result = $User->xInfo();

        $this->assertObjectHasAttribute('xinfo', $result, $User->requestPath());
        $this->assertObjectHasAttribute('shard', $result, $User->requestPath());
    }

    public function test_setUserLoc(): void
    {
        $User = $this->User();

        $result = $User->setUserLoc('г Краснодар, Улица Ленина 50', 45.023, 38.97358);

        $this->assertArrayHasKey('__region', $result, $User->requestPath());
        $this->assertArrayHasKey('__dst', $result, $User->requestPath());
    }

}
