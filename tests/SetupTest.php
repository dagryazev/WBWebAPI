<?php

namespace Dakword\WBWebAPI\Tests;

use Dakword\WBWebAPI\Setup;
use PHPUnit\Framework\TestCase;

class SetupTest extends TestCase
{

    public function test_User(): void
    {
        $setup = new Setup();
        $this->assertInstanceOf(Setup::class, $setup);
    }

    public function test_Exception(): void
    {
        $setup = new Setup();

        $this->expectException(\BadMethodCallException::class);
        $setup->setFoo('bar');
    }

    public function test_Reg(): void
    {
        $setup = new Setup(['reg' => 1]);
        $this->assertEquals(1, $setup->reg());
        
        $setup->setReg(0);
        $this->assertEquals(0, $setup->reg());
    }

    public function test_Regions(): void
    {
        $setup = (new Setup())->withRegions([12345, 67890]);

        $this->assertTrue(in_array(12345, $setup->regions()));
    }

}
