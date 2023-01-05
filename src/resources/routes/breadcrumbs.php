<?php

declare(strict_types=1);

Breadcrumbs::for('vanilo.admin.product.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Products'), route('vanilo.admin.product.index'));
});

Breadcrumbs::for('vanilo.admin.product.create', function ($breadcrumbs) {
    $breadcrumbs->parent('vanilo.admin.product.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('vanilo.admin.product.show', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('vanilo.admin.product.index');
    $breadcrumbs->push($product->name, route('vanilo.admin.product.show', $product));
});

Breadcrumbs::for('vanilo.admin.product.edit', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('vanilo.admin.product.show', $product);
    $breadcrumbs->push(__('Edit'), route('vanilo.admin.product.edit', $product));
});

Breadcrumbs::for('vanilo.admin.master_product.create', function ($breadcrumbs) {
    $breadcrumbs->parent('vanilo.admin.product.index');
    $breadcrumbs->push(__('Create Master Product'));
});

Breadcrumbs::for('vanilo.admin.master_product.show', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('vanilo.admin.product.index');
    $breadcrumbs->push($product->name, route('vanilo.admin.master_product.show', $product));
});

Breadcrumbs::for('vanilo.admin.master_product.edit', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('vanilo.admin.master_product.show', $product);
    $breadcrumbs->push(__('Edit'), route('vanilo.admin.master_product.edit', $product));
});

Breadcrumbs::for('vanilo.admin.master-product-variant.create', function ($breadcrumbs, $masterProduct) {
    $breadcrumbs->parent('vanilo.admin.master_product.show', $masterProduct);
    $breadcrumbs->push(__('Create Variant'));
});

Breadcrumbs::for('vanilo.admin.master-product-variant.edit', function ($breadcrumbs, $masterProduct, $masterProductVariant) {
    $breadcrumbs->parent('vanilo.admin.master_product.show', $masterProduct);
    $breadcrumbs->push($masterProductVariant->name);
});

Breadcrumbs::for('vanilo.admin.taxonomy.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Categorization'), route('vanilo.admin.taxonomy.index'));
});

Breadcrumbs::for('vanilo.admin.taxonomy.create', function ($breadcrumbs) {
    $breadcrumbs->parent('vanilo.admin.taxonomy.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('vanilo.admin.taxonomy.show', function ($breadcrumbs, $taxonomy) {
    $breadcrumbs->parent('vanilo.admin.taxonomy.index');
    $breadcrumbs->push($taxonomy->name, route('vanilo.admin.taxonomy.show', $taxonomy));
});

Breadcrumbs::for('vanilo.admin.taxonomy.edit', function ($breadcrumbs, $taxonomy) {
    $breadcrumbs->parent('vanilo.admin.taxonomy.show', $taxonomy);
    $breadcrumbs->push(__('Edit'), route('vanilo.admin.taxonomy.edit', $taxonomy));
});

Breadcrumbs::for('vanilo.admin.taxon.create', function ($breadcrumbs, $taxonomy) {
    $breadcrumbs->parent('vanilo.admin.taxonomy.show', $taxonomy);
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('vanilo.admin.taxon.edit', function ($breadcrumbs, $taxonomy, $taxon) {
    $breadcrumbs->parent('vanilo.admin.taxonomy.show', $taxonomy);
    $breadcrumbs->push($taxon->name);
});

Breadcrumbs::for('vanilo.admin.order.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Orders'), route('vanilo.admin.order.index'));
});

Breadcrumbs::for('vanilo.admin.order.show', function ($breadcrumbs, $order) {
    $breadcrumbs->parent('vanilo.admin.order.index');
    $breadcrumbs->push($order->getNumber(), route('vanilo.admin.order.show', $order));
});

Breadcrumbs::for('vanilo.admin.property.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Properties'), route('vanilo.admin.property.index'));
});

Breadcrumbs::for('vanilo.admin.property.create', function ($breadcrumbs) {
    $breadcrumbs->parent('vanilo.admin.property.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('vanilo.admin.property.show', function ($breadcrumbs, $property) {
    $breadcrumbs->parent('vanilo.admin.property.index');
    $breadcrumbs->push($property->name, route('vanilo.admin.property.show', $property));
});

Breadcrumbs::for('vanilo.admin.property.edit', function ($breadcrumbs, $property) {
    $breadcrumbs->parent('vanilo.admin.property.show', $property);
    $breadcrumbs->push(__('Edit'), route('vanilo.admin.property.edit', $property));
});

Breadcrumbs::for('vanilo.admin.property_value.create', function ($breadcrumbs, $property) {
    $breadcrumbs->parent('vanilo.admin.property.show', $property);
    $breadcrumbs->push(__('Create Value'));
});

Breadcrumbs::for('vanilo.admin.property_value.edit', function ($breadcrumbs, $property, $propertyValue) {
    $breadcrumbs->parent('vanilo.admin.property.show', $property);
    $breadcrumbs->push($propertyValue->title);
});

Breadcrumbs::for('vanilo.admin.channel.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Channels'), route('vanilo.admin.channel.index'));
});

Breadcrumbs::for('vanilo.admin.channel.create', function ($breadcrumbs) {
    $breadcrumbs->parent('vanilo.admin.channel.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('vanilo.admin.channel.show', function ($breadcrumbs, $channel) {
    $breadcrumbs->parent('vanilo.admin.channel.index');
    $breadcrumbs->push($channel->name, route('vanilo.admin.channel.show', $channel));
});

Breadcrumbs::for('vanilo.admin.channel.edit', function ($breadcrumbs, $channel) {
    $breadcrumbs->parent('vanilo.admin.channel.show', $channel);
    $breadcrumbs->push(__('Edit'), route('vanilo.admin.channel.edit', $channel));
});

Breadcrumbs::for('vanilo.admin.payment-method.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Payment Methods'), route('vanilo.admin.payment-method.index'));
});

Breadcrumbs::for('vanilo.admin.payment-method.create', function ($breadcrumbs) {
    $breadcrumbs->parent('vanilo.admin.payment-method.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('vanilo.admin.payment-method.show', function ($breadcrumbs, $paymentMethod) {
    $breadcrumbs->parent('vanilo.admin.payment-method.index');
    $breadcrumbs->push($paymentMethod->name, route('vanilo.admin.payment-method.show', $paymentMethod));
});

Breadcrumbs::for('vanilo.admin.payment-method.edit', function ($breadcrumbs, $paymentMethod) {
    $breadcrumbs->parent('vanilo.admin.payment-method.show', $paymentMethod);
    $breadcrumbs->push(__('Edit'), route('vanilo.admin.payment-method.edit', $paymentMethod));
});
