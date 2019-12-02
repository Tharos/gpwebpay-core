<?php declare(strict_types=1);

namespace Pixidos\GPWebPay\Signer;

use Pixidos\GPWebPay\Exceptions;
use Pixidos\GPWebPay\Exceptions\SignerException;
use Pixidos\GPWebPay\Settings\Settings;

/**
 * Class SingerFactory
 * @package Pixidos\GPWebPay
 * @author Ondra Votava <ondrej.votava@pixidos.com>
 */
class SignerFactory implements ISignerFactory
{
    /**
     * @var ISigner[]
     */
    private $signers = [];

    /** @var Settings $settings */
    private $settings;

    /**
     * SignerFactory constructor.
     *
     * @param Settings $settings
     */
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param null|string $gatewayKey
     *
     * @return ISigner
     * @throws Exceptions\InvalidArgumentException
     * @throws SignerException
     */
    public function create(?string $gatewayKey = null): ISigner
    {
        $key = $this->settings->getGatewayKey($gatewayKey);
        if (array_key_exists($key, $this->signers)) {
            return $this->signers[$key];
        }

        return $this->signers[$key] =  new Signer(
            $this->settings->getPrivateKey($key),
            $this->settings->getPrivateKeyPassword($key),
            $this->settings->getPublicKey($key)
        );
    }
}