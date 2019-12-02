<?php declare(strict_types=1);

/**
 * Test: Pixidos\GPWebPay\Data\Response
 * @testCase PixidosTests\GPWebPay\ResponseTest
 */

namespace Pixidos\GPWebPay\Tests\Data;

use PHPUnit\Framework\TestCase;
use Pixidos\GPWebPay\Data\IResponse;
use Pixidos\GPWebPay\Data\Response;
use Pixidos\GPWebPay\Enum\Param;
use Pixidos\GPWebPay\Tests\TestHelpers;

/**
 * Class ResponseTest
 * @package PixidosTests\GPWebPay
 * @author Ondra Votava <ondra@votava.it>
 */
class ResponseTest extends TestCase
{

    public function testCreateGPWebPayResponse(): void
    {
        $params = TestHelpers::getTestParams();

        $response = new Response(
            $params[Param::OPERATION],
            $params[Param::ORDERNUMBER],
            $params[Param::MERORDERNUM],
            $params[Param::MD],
            (int)$params[IResponse::PRCODE],
            (int)$params[IResponse::SRCODE],
            $params[IResponse::RESULTTEXT],
            $params[Param::DIGEST],
            $params[IResponse::DIGEST_1],
            $params['gatewayKey']
        );

        $response->setUserParam1('userparam');

        self::assertSame('123456', $response->getOrderNumber());
        self::assertSame('FA12345', $response->getMerOrderNumber());
        self::assertSame('sometext', $response->getMd());
        self::assertSame(0, $response->getPrcode());
        self::assertSame(0, $response->getSrcode());
        self::assertSame('resulttext', $response->getResultText());
        self::assertSame('hash1', $response->getDigest());
        self::assertSame('hash2', $response->getDigest1());
        self::assertSame('czk', $response->getGatewayKey());
        self::assertSame('userparam', $response->getUserParam1());
        self::assertFalse($response->hasError());

    }


    public function testResponseParams(): void
    {
        $params = TestHelpers::getTestParams();
        $response = new Response(
            $params[Param::OPERATION],
            $params[Param::ORDERNUMBER],
            $params[Param::MERORDERNUM],
            $params[Param::MD],
            (int)$params[IResponse::PRCODE],
            (int)$params[IResponse::SRCODE],
            $params[IResponse::RESULTTEXT],
            $params[Param::DIGEST],
            $params[IResponse::DIGEST_1],
            $params['gatewayKey']
        );

        self::assertSame(
            [
                'OPERATION' => 'CREATE_ORDER',
                'ORDERNUMBER' => '123456',
                'MERORDERNUM' => 'FA12345',
                'MD' => 'czk|sometext',
                'PRCODE' => 0,
                'SRCODE' => 0,
                'RESULTTEXT' => 'resulttext',
            ],
            $response->getParams()
        );
    }


    public function testError(): void
    {
        $params = TestHelpers::getTestParams();

        $response = new Response(
            $params[Param::OPERATION],
            $params[Param::ORDERNUMBER],
            $params[Param::MERORDERNUM],
            $params[Param::MD],
            1000,
            30,
            $params[IResponse::RESULTTEXT],
            $params[Param::DIGEST],
            $params[IResponse::DIGEST_1],
            $params['gatewayKey']
        );

        self::assertTrue($response->hasError());

    }
}