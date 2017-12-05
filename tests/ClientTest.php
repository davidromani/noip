<?php

/**
 * Class ClientTest
 */
class ClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * testIsThereAnySyntaxError
     */
    public function testIsThereAnySyntaxError()
    {

        $var = new Buonzz\NoIP\Client('bz-gateway.ddns.net', 'buonzz', 'DarwinBiler01');
        $this->assertTrue(is_object($var));
        unset($var);

    }

    /**
     * testUpdate
     */
    public function testUpdate()
    {
        $client = new Buonzz\NoIP\Client();
        $this->assertEquals($client->update("112.206.26.201"), 'OK');
        unset($var);
    }
}
