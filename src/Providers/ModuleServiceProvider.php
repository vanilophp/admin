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

use Illuminate\Database\Eloquent\Relations\Relation;
use Konekt\AppShell\Acl\ResourcePermissionMapper;
use Konekt\AppShell\Breadcrumbs\HasBreadcrumbs;
use Konekt\Concord\BaseBoxServiceProvider;
use Menu;
use Vanilo\Category\Models\TaxonomyProxy;
use Vanilo\Category\Models\TaxonProxy;
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
use Vanilo\Order\Models\OrderProxy;
use Vanilo\Product\Models\ProductProxy;

class ModuleServiceProvider extends BaseBoxServiceProvider
{
    use HasBreadcrumbs;
    use RegistersVaniloIcons;

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
            $shop->addSubItem('products', __('Products'), ['route' => 'vanilo.product.index'])
                ->data('icon', 'product')
                ->activateOnUrls(route('vanilo.product.index', [], false) . '*')
                ->allowIfUserCan('list products');
            $shop->addSubItem('product_properties', __('Product Properties'), ['route' => 'vanilo.property.index'])
                ->data('icon', 'properties')
                ->activateOnUrls(route('vanilo.property.index', [], false) . '*')
                ->allowIfUserCan('list properties');
            $shop->addSubItem('categories', __('Categorization'), ['route' => 'vanilo.taxonomy.index'])
                ->data('icon', 'taxonomies')
                ->activateOnUrls(route('vanilo.taxonomy.index', [], false) . '*')
                ->allowIfUserCan('list taxonomies');
            $shop->addSubItem('orders', __('Orders'), ['route' => 'vanilo.order.index'])
                ->data('icon', 'bag')
                ->activateOnUrls(route('vanilo.order.index', [], false) . '*')
                ->allowIfUserCan('list orders');

            $settings = $menu->getItem('settings_group');
            $settings->addSubItem('channels', __('Channels'), ['route' => 'vanilo.channel.index'])
                ->data('icon', 'channel')
                ->activateOnUrls(route('vanilo.channel.index', [], false) . '*')
                ->allowIfUserCan('list channels');
            $settings->addSubItem('payment-methods', __('Payment Methods'), ['route' => 'vanilo.payment-method.index'])
                     ->data('icon', 'payment-method')
                     ->activateOnUrls(route('vanilo.payment-method.index', [], false) . '*')
                     ->allowIfUserCan('list payment methods');
        }
    }
}
