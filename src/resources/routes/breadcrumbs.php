<?php

declare(strict_types=1);

Breadcrumbs::for('vanilo.product.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Products'), route('vanilo.product.index'));
});

Breadcrumbs::for('vanilo.product.create', function ($breadcrumbs) {
    $breadcrumbs->parent('vanilo.product.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('vanilo.product.show', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('vanilo.product.index');
    $breadcrumbs->push($product->name, route('vanilo.product.show', $product));
});

Breadcrumbs::for('vanilo.product.edit', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('vanilo.product.show', $product);
    $breadcrumbs->push(__('Edit'), route('vanilo.product.edit', $product));
});

Breadcrumbs::for('vanilo.taxonomy.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Categorization'), route('vanilo.taxonomy.index'));
});

Breadcrumbs::for('vanilo.taxonomy.create', function ($breadcrumbs) {
    $breadcrumbs->parent('vanilo.taxonomy.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('vanilo.taxonomy.show', function ($breadcrumbs, $taxonomy) {
    $breadcrumbs->parent('vanilo.taxonomy.index');
    $breadcrumbs->push($taxonomy->name, route('vanilo.taxonomy.show', $taxonomy));
});

Breadcrumbs::for('vanilo.taxonomy.edit', function ($breadcrumbs, $taxonomy) {
    $breadcrumbs->parent('vanilo.taxonomy.show', $taxonomy);
    $breadcrumbs->push(__('Edit'), route('vanilo.taxonomy.edit', $taxonomy));
});

Breadcrumbs::for('vanilo.taxon.create', function ($breadcrumbs, $taxonomy) {
    $breadcrumbs->parent('vanilo.taxonomy.show', $taxonomy);
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('vanilo.taxon.edit', function ($breadcrumbs, $taxonomy, $taxon) {
    $breadcrumbs->parent('vanilo.taxonomy.show', $taxonomy);
    $breadcrumbs->push($taxon->name);
});

Breadcrumbs::for('vanilo.order.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Orders'), route('vanilo.order.index'));
});

Breadcrumbs::for('vanilo.order.show', function ($breadcrumbs, $order) {
    $breadcrumbs->parent('vanilo.order.index');
    $breadcrumbs->push($order->getNumber(), route('vanilo.order.show', $order));
});

Breadcrumbs::for('vanilo.property.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Properties'), route('vanilo.property.index'));
});

Breadcrumbs::for('vanilo.property.create', function ($breadcrumbs) {
    $breadcrumbs->parent('vanilo.property.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('vanilo.property.show', function ($breadcrumbs, $property) {
    $breadcrumbs->parent('vanilo.property.index');
    $breadcrumbs->push($property->name, route('vanilo.property.show', $property));
});

Breadcrumbs::for('vanilo.property.edit', function ($breadcrumbs, $property) {
    $breadcrumbs->parent('vanilo.property.show', $property);
    $breadcrumbs->push(__('Edit'), route('vanilo.property.edit', $property));
});

Breadcrumbs::for('vanilo.property_value.create', function ($breadcrumbs, $property) {
    $breadcrumbs->parent('vanilo.property.show', $property);
    $breadcrumbs->push(__('Create Value'));
});

Breadcrumbs::for('vanilo.property_value.edit', function ($breadcrumbs, $property, $propertyValue) {
    $breadcrumbs->parent('vanilo.property.show', $property);
    $breadcrumbs->push($propertyValue->title);
});

Breadcrumbs::for('vanilo.channel.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Channels'), route('vanilo.channel.index'));
});

Breadcrumbs::for('vanilo.channel.create', function ($breadcrumbs) {
    $breadcrumbs->parent('vanilo.channel.index');
    $breadcrumbs->push(__('Create'));
});

Breadcrumbs::for('vanilo.channel.show', function ($breadcrumbs, $channel) {
    $breadcrumbs->parent('vanilo.channel.index');
    $breadcrumbs->push($channel->name, route('vanilo.channel.show', $channel));
});

Breadcrumbs::for('vanilo.channel.edit', function ($breadcrumbs, $channel) {
    $breadcrumbs->parent('vanilo.channel.show', $channel);
    $breadcrumbs->push(__('Edit'), route('vanilo.channel.edit', $channel));
});
