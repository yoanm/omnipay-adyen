<?php
namespace Omnipay\AdyenApi\Tests\Message\Payment\CancelOrRefund;

use Omnipay\AdyenApi\Message\Payment\CancelOrRefund\Request;
use Omnipay\AdyenApi\Message\Payment\CancelOrRefund\Response;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * Class ResponseTest
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /** @var Request|ObjectProphecy */
    private $request;

    /**
     * @{inheritdoc}
     */
    public function setUp()
    {
        $this->request = $this->prophesize('Omnipay\Common\Message\RequestInterface');
    }


    /**
     */
    public function testIsSuccessful()
    {
        $response = new Response(
            $this->request->reveal(),
            json_encode(array('response' => Response::RESPONSE_RECEIVED))
        );

        $this->assertTrue($response->isSuccessful());
    }

    /**
     * @dataProvider getIsNotSuccessfulData
     * @param array $data
     */
    public function testIsNotSuccessful(array $data)
    {
        $response = new Response(
            $this->request->reveal(),
            json_encode($data)
        );

        $this->assertFalse($response->isSuccessful());
    }

    /**
     * @return array
     */
    public function getIsNotSuccessfulData()
    {
        return array(
            'invalid' => array(array('response' => 'plop')),
            'not_provided' => array(array('response' => null)),
        );
    }
}
