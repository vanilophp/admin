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

use Konekt\AppShell\Acl\ResourcePermissionMapper;
use Konekt\AppShell\Breadcrumbs\HasBreadcrumbs;
use Konekt\Concord\BaseBoxServiceProvider;
use Menu;
use Vanilo\Admin\Http\Requests\CreateChannel;
use Vanilo\Admin\Http\Requests\CreateMedia;
use Vanilo\Admin\Http\Requests\CreatePaymentMethod;
use Vanilo\Admin\Http\Requests\CreateProduct;
use Vanilo\Admin\Http\Requests\CreateProperty;
use Vanilo\Admin\Http\Requests\CreatePropertyValue;
use Vanilo\Admin\Http\Requests\CreatePropertyValueForm;
use Vanilo\Admin\Http\Requests\CreateTaxon;
use Vanilo\Admin\Http\Requests\CreateTaxonForm;
use Vanilo\Admin\Http\Requests\CreateTaxonomy;
use Vanilo\Admin\Http\Requests\SyncModelPropertyValues;
use Vanilo\Admin\Http\Requests\SyncModelTaxons;
use Vanilo\Admin\Http\Requests\UpdateChannel;
use Vanilo\Admin\Http\Requests\UpdateOrder;
use Vanilo\Admin\Http\Requests\UpdatePaymentMethod;
use Vanilo\Admin\Http\Requests\UpdateProduct;
use Vanilo\Admin\Http\Requests\UpdateProperty;
use Vanilo\Admin\Http\Requests\UpdatePropertyValue;
use Vanilo\Admin\Http\Requests\UpdateTaxon;
use Vanilo\Admin\Http\Requests\UpdateTaxonomy;
use Vanilo\Admin\Models\SkuMode;

class ModuleServiceProvider extends BaseBoxServiceProvider
{
    use HasBreadcrumbs;
    use RegistersVaniloIcons;

    protected $enums = [
        SkuMode::class,
    ];

    protected $requests = [
        CreateProduct::class,
        UpdateProduct::class,
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
        UpdatePaymentMethod::class
    ];

    public function boot()
    {
        parent::boot();

        $this->app->get(ResourcePermissionMapper::class)->overrideResourcePlural('taxon', 'taxons');

        $this->registerIconExtensions();
        $this->registerEnumIcons();
        $this->loadBreadcrumbs();
        $this->addMenuItems();
    }

    protected function addMenuItems()
    {
        if ($menu = Menu::get('appshell')) {
            $shop = $menu->addItem('shop', __('Shop'));
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
            $shop->addSubItem('orders', __('Orders'), ['route' => 'vanilo.admin.order.index'])
                ->data('icon', 'bag')
                ->activateOnUrls(route('vanilo.admin.order.index', [], false) . '*')
                ->allowIfUserCan('list orders');

            $settings = $menu->getItem('settings_group');
            $settings->addSubItem('channels', __('Channels'), ['route' => 'vanilo.admin.channel.index'])
                ->data('icon', 'channel')
                ->activateOnUrls(route('vanilo.admin.channel.index', [], false) . '*')
                ->allowIfUserCan('list channels');
            $settings->addSubItem('payment-methods', __('Payment Methods'), ['route' => 'vanilo.admin.payment-method.index'])
                     ->data('icon', 'payment-method')
                     ->activateOnUrls(route('vanilo.admin.payment-method.index', [], false) . '*')
                     ->allowIfUserCan('list payment methods');
        }
    }
}
