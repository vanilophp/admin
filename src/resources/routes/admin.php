<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Vanilo's Admin Routes
|
| Routes in this file will be added in a group attributes of which
| are to be defined in the box/module config file in the config
| key of routes.namespace, routes.prefix with smart defaults
|--------------------------------------------------------------------------
*/

Route::resource('channel', 'ChannelController');
Route::resource('zone', 'ZoneController');
Route::resource('taxonomy', 'TaxonomyController');
Route::resource('product', 'ProductController');
Route::resource('master_product', 'MasterProductController')->except(['index']);
Route::resource('property', 'PropertyController');
Route::resource('order', 'OrderController');
Route::resource('media', 'MediaController')->only(['update', 'destroy', 'store']);
Route::resource('carrier', 'CarrierController');
Route::resource('payment-method', 'PaymentMethodController')
     ->parameters(['payment-method' => 'paymentMethod']);
Route::resource('shipping-method', 'ShippingMethodController')
    ->parameters(['shipping-method' => 'shippingMethod']);

Route::get('/taxonomy/{taxonomy}/taxon/create', 'TaxonController@create')->name('taxon.create');
Route::post('/taxonomy/{taxonomy}/taxon', 'TaxonController@store')->name('taxon.store');
Route::get('/taxonomy/{taxonomy}/taxon/{taxon}/edit', 'TaxonController@edit')->name('taxon.edit');
Route::put('/taxonomy/{taxonomy}/taxon/{taxon}', 'TaxonController@update')->name('taxon.update');
Route::delete('/taxonomy/{taxonomy}/taxon/{taxon}', 'TaxonController@destroy')->name('taxon.destroy');

Route::put('/taxonomy/{taxonomy}/sync', 'TaxonomyController@sync')->name('taxonomy.sync');

Route::get('/property/{property}/value/create', 'PropertyValueController@create')->name('property_value.create');
Route::post('/property/{property}/value', 'PropertyValueController@store')->name('property_value.store');
Route::get('/property/{property}/value/{property_value}/edit', 'PropertyValueController@edit')->name('property_value.edit');
Route::put('/property/{property}/value/{property_value}', 'PropertyValueController@update')->name('property_value.update');
Route::delete('/property/{property}/value/{property_value}', 'PropertyValueController@destroy')->name('property_value.destroy');
Route::put('/property/sync/{for}/{forId}', 'PropertyValueController@sync')->name('property_value.sync');

Route::get('/master-product/{masterProduct}/variant/create', 'MasterProductVariantController@create')->name('master_product_variant.create');
Route::post('/master-product/{masterProduct}/variant', 'MasterProductVariantController@store')->name('master_product_variant.store');
Route::get('/master-product/{masterProduct}/variant/{masterProductVariant}/edit', 'MasterProductVariantController@edit')->name('master_product_variant.edit');
Route::get('/master-product/{masterProduct}/variant/{masterProductVariant}', 'MasterProductVariantController@show')->name('master_product_variant.show');
Route::put('/master-product/{masterProduct}/variant/{masterProductVariant}', 'MasterProductVariantController@update')->name('master_product_variant.update');
Route::delete('/master-product/{masterProduct}/variant/{masterProductVariant}', 'MasterProductVariantController@destroy')->name('master_product_variant.destroy');

Route::get('/zone/{zone}/member/create', 'ZoneMemberController@create')->name('zone_member.create');
Route::post('/zone/{zone}/member', 'ZoneMemberController@store')->name('zone_member.store');
Route::delete('/zone/{zone}/member/{zoneMember}', 'ZoneMemberController@destroy')->name('zone_member.destroy');
