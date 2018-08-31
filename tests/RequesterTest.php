<?php
/**
 * Created by PhpStorm.
 * User: ram
 * Date: 31/08/2018
 * Time: 18:17
 */

namespace SearchEngineAggregator\Test;


use Goutte\Client;
use SearchEngineAggregator\Requester;

/**
 * Class RequesterTest
 * @package SearchEngineAggregator\Test
 */
class RequesterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetClient()
    {
        $requester = new Requester();
        $this->assertInstanceOf(Client::class, $requester->getClient());
    }
}