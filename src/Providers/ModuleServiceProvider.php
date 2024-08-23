<?php

declare(strict_types=1);

/**
 * Contains the ModuleServiceProvider class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-09
 *
 */

namespace Vanilo\Admin\Providers;

use Konekt\Address\Models\ZoneScope;
use Konekt\Address\Models\ZoneScopeProxy;
use Konekt\AppShell\Acl\ResourcePermissionMapper;
use Konekt\AppShell\Breadcrumbs\HasBreadcrumbs;
use Konekt\AppShell\EnumColors;
use Konekt\AppShell\Theme\ThemeColor;
use Konekt\AppShell\Widgets;
use Konekt\Concord\BaseBoxServiceProvider;
use Konekt\Menu\Facades\Menu;
use Vanilo\Admin\Http\Requests\AssignChannels;
use Vanilo\Admin\Http\Requests\CreateCarrier;
use Vanilo\Admin\Http\Requests\CreateChannel;
use Vanilo\Admin\Http\Requests\CreateCoupon;
use Vanilo\Admin\Http\Requests\CreateLink;
use Vanilo\Admin\Http\Requests\CreateLinkForm;
use Vanilo\Admin\Http\Requests\CreateMasterProduct;
use Vanilo\Admin\Http\Requests\CreateMasterProductVariant;
use Vanilo\Admin\Http\Requests\CreateMedia;
use Vanilo\Admin\Http\Requests\CreatePaymentMethod;
use Vanilo\Admin\Http\Requests\CreateProduct;
use Vanilo\Admin\Http\Requests\CreatePromotion;
use Vanilo\Admin\Http\Requests\CreatePromotionRule;
use Vanilo\Admin\Http\Requests\CreateProperty;
use Vanilo\Admin\Http\Requests\CreatePropertyValue;
use Vanilo\Admin\Http\Requests\CreatePropertyValueForm;
use Vanilo\Admin\Http\Requests\CreateShippingMethod;
use Vanilo\Admin\Http\Requests\CreateTaxCategory;
use Vanilo\Admin\Http\Requests\CreateTaxon;
use Vanilo\Admin\Http\Requests\CreateTaxonForm;
use Vanilo\Admin\Http\Requests\CreateTaxonomy;
use Vanilo\Admin\Http\Requests\CreateTaxRate;
use Vanilo\Admin\Http\Requests\CreateZone;
use Vanilo\Admin\Http\Requests\CreateZoneMember;
use Vanilo\Admin\Http\Requests\SyncModelPropertyValues;
use Vanilo\Admin\Http\Requests\SyncModelTaxons;
use Vanilo\Admin\Http\Requests\UpdateCarrier;
use Vanilo\Admin\Http\Requests\UpdateChannel;
use Vanilo\Admin\Http\Requests\UpdateCoupon;
use Vanilo\Admin\Http\Requests\UpdateMasterProduct;
use Vanilo\Admin\Http\Requests\UpdateMasterProductVariant;
use Vanilo\Admin\Http\Requests\UpdateOrder;
use Vanilo\Admin\Http\Requests\UpdatePaymentMethod;
use Vanilo\Admin\Http\Requests\UpdateProduct;
use Vanilo\Admin\Http\Requests\UpdatePromotion;
use Vanilo\Admin\Http\Requests\UpdatePromotionRule;
use Vanilo\Admin\Http\Requests\UpdateProperty;
use Vanilo\Admin\Http\Requests\UpdatePropertyValue;
use Vanilo\Admin\Http\Requests\UpdateShippingMethod;
use Vanilo\Admin\Http\Requests\UpdateTaxCategory;
use Vanilo\Admin\Http\Requests\UpdateTaxon;
use Vanilo\Admin\Http\Requests\UpdateTaxonomy;
use Vanilo\Admin\Http\Requests\UpdateTaxRate;
use Vanilo\Admin\Http\Requests\UpdateZone;
use Vanilo\Order\Models\OrderStatus;
use Vanilo\Order\Models\OrderStatusProxy;
use Vanilo\Product\Models\ProductState;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Taxes\Models\TaxCategoryType;
use Vanilo\Taxes\Models\TaxCategoryTypeProxy;

class ModuleServiceProvider extends BaseBoxServiceProvider
{
    use HasBreadcrumbs;
    use RegistersVaniloIcons;

    protected $requests = [
        CreateProduct::class,
        UpdateProduct::class,
        CreateMasterProduct::class,
        UpdateMasterProduct::class,
        CreateMasterProductVariant::class,
        UpdateMasterProductVariant::class,
        UpdateOrder::class,
        CreateTaxonomy::class,
        UpdateTaxonomy::class,
        CreateTaxon::class,
        UpdateTaxon::class,
        CreateTaxonForm::class,
        SyncModelTaxons::class,
        CreateMedia::class,
        CreateProperty::class,
        UpdateProperty::class,
        CreatePropertyValueForm::class,
        CreatePropertyValue::class,
        UpdatePropertyValue::class,
        SyncModelPropertyValues::class,
        CreateChannel::class,
        UpdateChannel::class,
        CreatePaymentMethod::class,
        UpdatePaymentMethod::class,
        CreateShippingMethod::class,
        UpdateShippingMethod::class,
        CreateCarrier::class,
        UpdateCarrier::class,
        CreateZone::class,
        UpdateZone::class,
        CreateZoneMember::class,
        AssignChannels::class,
        CreateTaxCategory::class,
        UpdateTaxCategory::class,
        CreateTaxRate::class,
        UpdateTaxRate::class,
        CreateLinkForm::class,
        CreateLink::class,
        CreatePromotion::class,
        UpdatePromotion::class,
        CreateCoupon::class,
        UpdateCoupon::class,
        CreatePromotionRule::class,
        UpdatePromotionRule::class,
    ];

    public function register(): void
    {
        parent::register();

        Widgets::registerWidgetNamespace('vanilo', $this->basePath . '/resources/widgets');
    }

    public function boot()
    {
        parent::boot();

        /** @var ResourcePermissionMapper $aclResourceMapper */
        $aclResourceMapper = $this->app->get(ResourcePermissionMapper::class);
        $aclResourceMapper->overrideResourcePlural('taxon', 'taxons');
        $aclResourceMapper->addAlias('master product', 'product');
        $aclResourceMapper->addAlias('master product variant', 'product');
        $aclResourceMapper->addAlias('promotion rule', 'promotion');
        $aclResourceMapper->addAlias('promotion action', 'promotion');
        $aclResourceMapper->addAlias('zone member', 'zone');
        $aclResourceMapper->addAlias('link', 'product');
        $aclResourceMapper->addAlias('payment', 'order');

        $this->registerIconExtensions();
        $this->registerEnumIcons();
        $this->registerEnumColors();
        $this->loadBreadcrumbs();
        $this->addMenuItems();
    }

    protected function addMenuItems()
    {
        if ($menu = Menu::get('appshell')) {
            $shop = $menu->addItem('shop', __('Shop'));
            $shop->addSubItem('orders', __('Orders'), ['route' => ['vanilo.admin.order.index', 'status' => 'open']])
                ->data('icon', 'bag')
                ->activateOnUrls(route('vanilo.admin.order.index', [], false) . '*')
                ->allowIfUserCan('list orders');
            $shop->addSubItem('products', __('Products'), ['route' => 'vanilo.admin.product.index'])
                ->data('icon', 'product')
                ->activateOnUrls(route('vanilo.admin.product.index', [], false) . '*')
                ->allowIfUserCan('list products');
            $shop->addSubItem('product_properties', __('Product Properties'), ['route' => 'vanilo.admin.property.index'])
                ->data('icon', 'properties')
                ->activateOnUrls(route('vanilo.admin.property.index', [], false) . '*')
                ->allowIfUserCan('list properties');
            $shop->addSubItem('categories', __('Categorization'), ['route' => 'vanilo.admin.taxonomy.index'])
                ->data('icon', 'taxonomies')
                ->activateOnUrls(route('vanilo.admin.taxonomy.index', [], false) . '*')
                ->allowIfUserCan('list taxonomies');
            $shop->addSubItem('promotions', __('Promotions'), ['route' => 'vanilo.admin.promotion.index'])
                ->data('icon', 'promotion')
                ->activateOnUrls(route('vanilo.admin.promotion.index', [], false) . '*')
                ->allowIfUserCan('list promotions');

            $settings = $menu->getItem('settings_group');
            $settings->addSubItem('channels', __('Channels'), ['route' => 'vanilo.admin.channel.index'])
                ->data('icon', 'channel')
                ->activateOnUrls(route('vanilo.admin.channel.index', [], false) . '*')
                ->allowIfUserCan('list channels');
            $settings->addSubItem('zones', __('Zones'), ['route' => 'vanilo.admin.zone.index'])
                ->data('icon', 'zone')
                ->activateOnUrls(route('vanilo.admin.zone.index', [], false) . '*')
                ->allowIfUserCan('list zones');
            $settings->addSubItem('payment-methods', __('Payment Methods'), ['route' => 'vanilo.admin.payment-method.index'])
                     ->data('icon', 'payment-method')
                     ->activateOnUrls(route('vanilo.admin.payment-method.index', [], false) . '*')
                     ->allowIfUserCan('list payment methods');
            $settings->addSubItem('shipping-methods', __('Shipping Methods'), ['route' => 'vanilo.admin.shipping-method.index'])
                ->data('icon', 'shipping')
                ->activateOnUrls(route('vanilo.admin.shipping-method.index', [], false) . '*')
                ->allowIfUserCan('list shipping methods');
            $settings->addSubItem('carriers', __('Carriers'), ['route' => 'vanilo.admin.carrier.index'])
                ->data('icon', 'carrier')
                ->activateOnUrls(route('vanilo.admin.carrier.index', [], false) . '*')
                ->allowIfUserCan('list carriers');
            $settings->addSubItem('tax-rates', __('Tax Rates'), ['route' => 'vanilo.admin.tax-rate.index'])
                ->data('icon', 'percent')
                ->activateOnUrls(route('vanilo.admin.tax-rate.index', [], false) . '*')
                ->allowIfUserCan('list carriers');
            $settings->addSubItem('tax-categories', __('Tax Categories'), ['route' => 'vanilo.admin.tax-category.index'])
                ->data('icon', 'tax')
                ->activateOnUrls(route('vanilo.admin.tax-category.index', [], false) . '*')
                ->allowIfUserCan('list carriers');
        }
    }

    private function registerEnumColors(): void
    {
        EnumColors::registerEnumColor(
            ZoneScopeProxy::enumClass(),
            [
                ZoneScope::SHIPPING => ThemeColor::SUCCESS(),
                ZoneScope::BILLING => ThemeColor::INFO(),
                ZoneScope::TAXATION => ThemeColor::WARNING(),
                ZoneScope::PRICING => ThemeColor::PRIMARY(),
                ZoneScope::CONTENT => ThemeColor::SECONDARY(),
            ]
        );

        EnumColors::registerEnumColor(
            ProductStateProxy::enumClass(),
            [
                ProductState::DRAFT => ThemeColor::SECONDARY(),
                ProductState::INACTIVE => ThemeColor::SECONDARY(),
                ProductState::ACTIVE => ThemeColor::SUCCESS(),
                ProductState::UNAVAILABLE => ThemeColor::WARNING(),
                ProductState::RETIRED => ThemeColor::LIGHT(),
            ]
        );

        EnumColors::registerEnumColor(
            OrderStatusProxy::enumClass(),
            [
                OrderStatus::PENDING => ThemeColor::WARNING(),
                OrderStatus::PROCESSING => ThemeColor::INFO(),
                OrderStatus::COMPLETED => ThemeColor::SUCCESS(),
                OrderStatus::CANCELLED => ThemeColor::SECONDARY(),
            ]
        );

        EnumColors::registerEnumColor(
            TaxCategoryTypeProxy::enumClass(),
            [
                TaxCategoryType::PHYSICAL_GOODS => ThemeColor::PRIMARY(),
                TaxCategoryType::TRANSPORT_SERVICES => ThemeColor::SECONDARY(),
                TaxCategoryType::DIGITAL_GOODS_AND_SERVICES => ThemeColor::DARK(),
                TaxCategoryType::LOCATION_TIED_SERVICES => ThemeColor::PRIMARY(),
                TaxCategoryType::INTANGIBLE_SERVICES => ThemeColor::INFO(),
                TaxCategoryType::REAL_ESTATE_SERVICES => ThemeColor::DARK(),
                TaxCategoryType::EVENT_RELATED_SERVICES => ThemeColor::SUCCESS(),
                TaxCategoryType::TELECOM_SERVICES => ThemeColor::INFO(),
                TaxCategoryType::BROADCASTING => ThemeColor::INFO(),
            ]
        );
    }
}
