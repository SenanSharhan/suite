<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ShopApplication;

use SprykerShop\Yves\CurrencyWidget\Plugin\ShopUi\CurrencyWidgetPlugin;
use SprykerShop\Yves\CustomerPage\Plugin\CustomerPage\CustomerNavigationWidgetPlugin;
use SprykerShop\Yves\LanguageSwitcherWidget\Plugin\ShopUi\LanguageSwitcherWidgetPlugin;
use SprykerShop\Yves\NavigationWidget\Plugin\ShopUi\NavigationWidgetPlugin;
use SprykerShop\Yves\PriceWidget\Plugin\ShopUi\PriceModeSwitcherWidgetPlugin;
use SprykerShop\Yves\ShopApplication\ShopApplicationDependencyProvider as SprykerShopApplicationDependencyProvider;

class ShopApplicationDependencyProvider extends SprykerShopApplicationDependencyProvider
{
    /**
     * @return string[]
     */
    protected function getGlobalWidgetPlugins(): array
    {
        return [
            CurrencyWidgetPlugin::class,
            LanguageSwitcherWidgetPlugin::class,
            NavigationWidgetPlugin::class,
            PriceModeSwitcherWidgetPlugin::class,
            CustomerNavigationWidgetPlugin::class,
        ];
    }

    /**
     * @return \SprykerShop\Yves\ShopApplicationExtension\Dependency\Plugin\FilterControllerEventHandlerPluginInterface[]
     */
    protected function getFilterControllerEventSubscriberPlugins(): array
    {
        return [];
    }
}
