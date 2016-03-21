<?php
namespace OhSky\DocomoApi;

use PHPUnit_Framework_TestCase;

class DocomoApiTest extends PHPUnit_Framework_TestCase
{
    public $docomoApi;

    public function setUp()
    {
        parent::setUp();
        $this->docomoApi = new DocomoApi();
    }

    public function testDummy()
    {
        $this->assertTrue(true);
    }
}
