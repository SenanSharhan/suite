<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\AlexaBot;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\AlexaBot\AlexaBotFactory getFactory()
 */
class AlexaBotClient extends AbstractClient implements AlexaBotClientInterface
{
    /**
     * @param string $productName
     *
     * @return string[]
     */
    public function getVariantsByProductName($productName)
    {
        return $this->getFactory()
            ->createAlexaProduct()
            ->getVariantsByProductName($productName);
    }

    /**
     * @param string $variantName
     *
     * @return bool
     */
    public function addVariantToCart($variantName)
    {
        return $this->getFactory()
            ->createAlexaCart()
            ->addVariantToCart($variantName);
    }

    /**
     * @return bool
     */
    public function checkoutAndPlaceOrder()
    {
        return $this->getFactory()
            ->createAlexaCheckoutAndOrder()
            ->checkoutAndPlaceOrder();
    }
}
