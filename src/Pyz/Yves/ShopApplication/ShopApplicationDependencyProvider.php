<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ShopApplication;

use Pyz\Yves\ExampleProductColorGroupWidget\Widget\ExampleProductColorSelectorWidget;
use SprykerShop\Yves\AgentWidget\Plugin\Widget\AgentWidgetPlugin;
use SprykerShop\Yves\AgentWidget\Widget\AgentControlBarWidget;
use SprykerShop\Yves\AvailabilityWidget\Widget\ProductViewAvailabilityWidget;
use SprykerShop\Yves\BusinessOnBehalfWidget\Plugin\CustomerPage\MenuItemBusinessOnBehalfWidgetPlugin;
use SprykerShop\Yves\BusinessOnBehalfWidget\Plugin\ShopUi\DisplayOnBehalfBusinessWidgetPlugin;
use SprykerShop\Yves\BusinessOnBehalfWidget\Widget\BusinessOnBehalfStatusWidget;
use SprykerShop\Yves\CartNoteWidget\Widget\CartItemNoteFormWidget;
use SprykerShop\Yves\CartNoteWidget\Widget\CartNoteFormWidget;
use SprykerShop\Yves\CartNoteWidget\Widget\DisplayCartItemNoteWidget;
use SprykerShop\Yves\CartNoteWidget\Widget\DisplayCartNoteWidget;
use SprykerShop\Yves\CartNoteWidget\Widget\DisplayOrderItemNoteWidget;
use SprykerShop\Yves\CartNoteWidget\Widget\DisplayOrderNoteWidget;
use SprykerShop\Yves\CartToShoppingListWidget\Widet\CreateShoppingListFromCartWidget;
use SprykerShop\Yves\ChartWidget\Widget\ChartWidget;
use SprykerShop\Yves\CheckoutWidget\Widget\CheckoutBreadcrumbWidget;
use SprykerShop\Yves\CmsBlockWidget\Widget\CatalogWithCmsBlockWidget;
use SprykerShop\Yves\CmsBlockWidget\Widget\ProductWithCmsBlockWidget;
use SprykerShop\Yves\CompanyPage\Plugin\ShopApplication\CheckBusinessOnBehalfCompanyUserHandlerPlugin;
use SprykerShop\Yves\CompanyPage\Plugin\ShopApplication\CompanyUserRestrictionHandlerPlugin;
use SprykerShop\Yves\CompanyWidget\Plugin\ShopUi\MenuItemCompanyWidgetPlugin;
use SprykerShop\Yves\CompanyWidget\Widget\CompanyMenuItemWidget;
use SprykerShop\Yves\CurrencyWidget\Plugin\ShopUi\CurrencyWidgetPlugin;
use SprykerShop\Yves\CurrencyWidget\Widget\CurrencyWidget;
use SprykerShop\Yves\CustomerPage\Plugin\CustomerPage\CustomerNavigationWidgetPlugin;
use SprykerShop\Yves\CustomerPage\Widget\CustomerNavigationWidget;
use SprykerShop\Yves\CustomerReorderWidget\Widget\CustomerReorderWidget;
use SprykerShop\Yves\DiscountPromotionWidget\Widget\CartDiscountPromotionProductListWidget;
use SprykerShop\Yves\DiscountWidget\Widget\DiscountSummaryWidget;
use SprykerShop\Yves\DiscountWidget\Widget\VoucherFormWidget;
use SprykerShop\Yves\LanguageSwitcherWidget\Plugin\ShopUi\LanguageSwitcherWidgetPlugin;
use SprykerShop\Yves\LanguageSwitcherWidget\Widget\LanguageSwitcherWidget;
use SprykerShop\Yves\MultiCartWidget\Plugin\ShopUi\MiniCartWidgetPlugin;
use SprykerShop\Yves\MultiCartWidget\Widget\AddToMultiCartWidget;
use SprykerShop\Yves\MultiCartWidget\Widget\CartOperationsWidget;
use SprykerShop\Yves\MultiCartWidget\Widget\MiniCartWidget;
use SprykerShop\Yves\MultiCartWidget\Widget\MultiCartListWidget;
use SprykerShop\Yves\MultiCartWidget\Widget\QuickOrderPageWidget;
use SprykerShop\Yves\NavigationWidget\Plugin\ShopUi\NavigationWidgetPlugin;
use SprykerShop\Yves\NavigationWidget\Widget\NavigationWidget;
use SprykerShop\Yves\NewsletterWidget\Widget\NewsletterSubscriptionSummaryWidget;
use SprykerShop\Yves\PriceProductVolumeWidget\Widget\ProductPriceVolumeWidget;
use SprykerShop\Yves\PriceWidget\Plugin\ShopUi\PriceModeSwitcherWidgetPlugin;
use SprykerShop\Yves\PriceWidget\Widget\PriceModeSwitcherWidget;
use SprykerShop\Yves\PriceWidget\Widget\ProductPriceWidget;
use SprykerShop\Yves\ProductAlternativeWidget\Widget\ProductAlternativeListWidget;
use SprykerShop\Yves\ProductAlternativeWidget\Widget\ShoppingListProductAlternativeWidget;
use SprykerShop\Yves\ProductAlternativeWidget\Widget\WishlistProductAlternativeWidget;
use SprykerShop\Yves\ProductBarcodeWidget\Widget\ProductBarcodeWidget;
use SprykerShop\Yves\ProductBundleWidget\Widget\ProductBundleCartItemsListWidget;
use SprykerShop\Yves\ProductBundleWidget\Widget\ProductBundleItemCounterWidget;
use SprykerShop\Yves\ProductBundleWidget\Widget\ProductBundleItemsMultiCartItemsListWidget;
use SprykerShop\Yves\ProductBundleWidget\Widget\ProductBundleMultiCartItemsListWidget;
use SprykerShop\Yves\ProductCategoryWidget\Widget\ProductBreadcrumbsWithCategoriesWidget;
use SprykerShop\Yves\ProductDiscontinuedWidget\Widget\ProductDiscontinuedNoteWidget;
use SprykerShop\Yves\ProductDiscontinuedWidget\Widget\ProductDiscontinuedWidget;
use SprykerShop\Yves\ProductGroupWidget\Plugin\ShopUi\ProductGroupWidgetPlugin;
use SprykerShop\Yves\ProductGroupWidget\Widget\ProductGroupWidget;
use SprykerShop\Yves\ProductImageWidget\Widget\ProductImageSliderWidget;
use SprykerShop\Yves\ProductLabelWidget\Widget\ProductAbstractLabelWidget;
use SprykerShop\Yves\ProductLabelWidget\Widget\ProductConcreteLabelWidget;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Widget\CartProductMeasurementUnitQuantitySelectorWidget;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Widget\ManageProductMeasurementUnitWidget;
use SprykerShop\Yves\ProductOptionWidget\Widget\DisplayCartItemProductOptionWidget;
use SprykerShop\Yves\ProductOptionWidget\Widget\ProductOptionConfiguratorWidget;
use SprykerShop\Yves\ProductPackagingUnitWidget\Widget\CartProductPackagingUnitWidget;
use SprykerShop\Yves\ProductPackagingUnitWidget\Widget\OrderDetailProductPackagingUnitWidget;
use SprykerShop\Yves\ProductPackagingUnitWidget\Widget\ProductPackagingUnitWidget;
use SprykerShop\Yves\ProductPackagingUnitWidget\Widget\SummaryProductPackagingUnitWidget;
use SprykerShop\Yves\ProductRelationWidget\Widget\SimilarProductsWidget;
use SprykerShop\Yves\ProductRelationWidget\Widget\UpSellingProductsWidget;
use SprykerShop\Yves\ProductReviewWidget\Widget\DisplayProductAbstractReviewWidget;
use SprykerShop\Yves\ProductReviewWidget\Widget\ProductDetailPageReviewWidget;
use SprykerShop\Yves\ProductReviewWidget\Widget\ProductRatingFilterWidget;
use SprykerShop\Yves\ProductReviewWidget\Widget\ProductReviewDisplayWidget;
use SprykerShop\Yves\ProductSetWidget\Widget\CmsContentProductSetWidget;
use SprykerShop\Yves\ProductSetWidget\Widget\ProductSetDetailPageWidget;
use SprykerShop\Yves\ProductWidget\Widget\CatalogPageProductWidget;
use SprykerShop\Yves\ProductWidget\Widget\CmsProductGroupWidget;
use SprykerShop\Yves\ProductWidget\Widget\CmsProductWidget;
use SprykerShop\Yves\ProductWidget\Widget\PdpProductRelationWidget;
use SprykerShop\Yves\ProductWidget\Widget\PdpProductReplacementForWidget;
use SprykerShop\Yves\ProductWidget\Widget\ProductAlternativeWidget;
use SprykerShop\Yves\SharedCartWidget\Widget\SharedCartAddSeparateProductWidget;
use SprykerShop\Yves\SharedCartWidget\Widget\SharedCartDetailsWidget;
use SprykerShop\Yves\SharedCartWidget\Widget\SharedCartOperationsWidget;
use SprykerShop\Yves\SharedCartWidget\Widget\SharedCartPermissionGroupWidget;
use SprykerShop\Yves\SharedCartWidget\Widget\SharedCartShareWidget;
use SprykerShop\Yves\ShopApplication\ShopApplicationDependencyProvider as SprykerShopApplicationDependencyProvider;
use SprykerShop\Yves\ShoppingListWidget\Widget\AddToShoppingListWidget;
use SprykerShop\Yves\ShoppingListWidget\Widget\ShoppingListMenuItemWidget;
use SprykerShop\Yves\WishlistWidget\Widget\PdpWishlistSelectorWidget;
use SprykerShop\Yves\WishlistWidget\Widget\WishlistMenuItemWidget;

class ShopApplicationDependencyProvider extends SprykerShopApplicationDependencyProvider
{
    /**
     * @return string[]
     */
    protected function getGlobalWidgets(): array
    {
        return [
            CurrencyWidgetPlugin::class,
            LanguageSwitcherWidgetPlugin::class,
            NavigationWidgetPlugin::class,
            NavigationWidget::class,
            ProductGroupWidgetPlugin::class,
            PriceModeSwitcherWidgetPlugin::class,
            MiniCartWidgetPlugin::class, #MultiCartFeature
            CustomerNavigationWidgetPlugin::class,
            DisplayOnBehalfBusinessWidgetPlugin::class,
            MenuItemBusinessOnBehalfWidgetPlugin::class,
            MenuItemCompanyWidgetPlugin::class,
            AgentWidgetPlugin::class, #AgentFeature

            AddToMultiCartWidget::class,
            AddToShoppingListWidget::class,
            AgentControlBarWidget::class,
            BusinessOnBehalfStatusWidget::class,
            CartDiscountPromotionProductListWidget::class,
            CartItemNoteFormWidget::class,
            CartNoteFormWidget::class,
            CartOperationsWidget::class,
            CartProductMeasurementUnitQuantitySelectorWidget::class,
            CartProductPackagingUnitWidget::class,
            CatalogPageProductWidget::class,
            CatalogWithCmsBlockWidget::class,
            ChartWidget::class,
            CheckoutBreadcrumbWidget::class,
            CmsContentProductSetWidget::class,
            CmsProductGroupWidget::class,
            CmsProductWidget::class,
            CompanyMenuItemWidget::class,
            CreateShoppingListFromCartWidget::class,
            CurrencyWidget::class,
            CustomerNavigationWidget::class,
            CustomerReorderWidget::class,
            DiscountSummaryWidget::class,
            DisplayCartItemNoteWidget::class,
            DisplayCartItemProductOptionWidget::class,
            DisplayCartNoteWidget::class,
            DisplayOrderItemNoteWidget::class,
            DisplayOrderNoteWidget::class,
            DisplayProductAbstractReviewWidget::class,
            ExampleProductColorSelectorWidget::class,
            LanguageSwitcherWidget::class,
            ManageProductMeasurementUnitWidget::class,
            MiniCartWidget::class,
            MultiCartListWidget::class,
            NavigationWidget::class,
            NewsletterSubscriptionSummaryWidget::class,
            OrderDetailProductPackagingUnitWidget::class,
            PdpProductRelationWidget::class,
            PdpProductReplacementForWidget::class,
            PdpWishlistSelectorWidget::class,
            PriceModeSwitcherWidget::class,
            ProductAbstractLabelWidget::class,
            ProductAlternativeListWidget::class,
            ProductAlternativeWidget::class,
            ProductBarcodeWidget::class,
            ProductBreadcrumbsWithCategoriesWidget::class,
            ProductBundleCartItemsListWidget::class,
            ProductBundleItemCounterWidget::class,
            ProductBundleItemsMultiCartItemsListWidget::class,
            ProductBundleMultiCartItemsListWidget::class,
            ProductConcreteLabelWidget::class,
            ProductDetailPageReviewWidget::class,
            ProductDiscontinuedNoteWidget::class,
            ProductDiscontinuedWidget::class,
            // ProductGroupWidget::class, todo: uncomment after fix
            ProductImageSliderWidget::class,
            ProductOptionConfiguratorWidget::class,
            ProductPackagingUnitWidget::class,
            ProductPriceVolumeWidget::class,
            ProductPriceWidget::class,
            ProductRatingFilterWidget::class,
            ProductReviewDisplayWidget::class,
            ProductSetDetailPageWidget::class,
            ProductViewAvailabilityWidget::class,
            ProductWithCmsBlockWidget::class,
            QuickOrderPageWidget::class,
            SharedCartAddSeparateProductWidget::class,
            SharedCartDetailsWidget::class,
            SharedCartOperationsWidget::class,
            SharedCartPermissionGroupWidget::class,
            SharedCartShareWidget::class,
            ShoppingListMenuItemWidget::class,
            ShoppingListProductAlternativeWidget::class,
            SimilarProductsWidget::class,
            SummaryProductPackagingUnitWidget::class,
            UpSellingProductsWidget::class,
            VoucherFormWidget::class,
            WishlistMenuItemWidget::class,
            WishlistProductAlternativeWidget::class,
        ];
    }

    /**
     * @return \SprykerShop\Yves\ShopApplicationExtension\Dependency\Plugin\FilterControllerEventHandlerPluginInterface[]
     */
    protected function getFilterControllerEventSubscriberPlugins(): array
    {
        return [
            new CompanyUserRestrictionHandlerPlugin(),
            new CheckBusinessOnBehalfCompanyUserHandlerPlugin(), #BusinessOnBehalfFeature
        ];
    }
}
