<?php declare(strict_types=1);
/**
 * This file is part of the Pixidos package.
 *
 *  (c) Ondra Votava <ondra@votava.dev>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 */

use Pixidos\GPWebPay\Config\Factory\ConfigFactory;
use Pixidos\GPWebPay\Config\Factory\PaymentConfigFactory;

$configFactory = new ConfigFactory(new PaymentConfigFactory());

$config = $configFactory->create(
    [
        ConfigFactory::PRIVATE_KEY => __DIR__ . '/_certs/test.pem',
        ConfigFactory::PRIVATE_KEY_PASSPHRASE => '1234567',
        ConfigFactory::PUBLIC_KEY => __DIR__ . '/_certs/test-pub.pem',
        ConfigFactory::URL => 'https://test.3dsecure.gpwebpay.com/unicredit/order.do',
        ConfigFactory::MERCHANT_NUMBER => '123456789',
        ConfigFactory::DEPOSIT_FLAG => 1,
        ConfigFactory::RESPONSE_URL => 'http://example.com/proccess-gpw-response'
    ]
);
