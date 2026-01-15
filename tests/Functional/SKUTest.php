<?php

namespace Functional;

use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Vanilo\Admin\Tests\Functional\TestCase;
use Vanilo\Foundation\Models\MasterProduct;
use Vanilo\Foundation\Models\MasterProductVariant;
use Vanilo\Foundation\Models\Product;
use Vanilo\Product\Models\ProductState;

class SKUTest extends TestCase
{
    #[Test]
    public function a_product_with_a_unique_sku_can_be_created()
    {
        $sku = Str::ulid()->toBase58();
        $response = $this->actingAs($this->admin)->post(
            route('vanilo.admin.product.store'),
            [
                'name' => 'Gizmondo Smart Thermostat WiFi',
                'sku' => $sku,
                'state' => ProductState::ACTIVE(),
                'price' => 199.99,
            ]
        );

        $response->assertRedirect();

        $product = Product::findBySku($sku);
        $this->assertInstanceOf(Product::class, $product);
        $this->assertSame($sku, $product->sku);
        $this->assertSame('Gizmondo Smart Thermostat WiFi', $product->name);
        $this->assertSame(199.99, $product->price);
    }

    #[Test]
    public function a_variant_with_a_unique_sku_can_be_created()
    {
        $master = MasterProduct::create([
            'name' => 'BIRAI® Round Smart Thermostat',
        ]);

        $sku = Str::ulid()->toBase58();
        $response = $this->actingAs($this->admin)->post(
            route('vanilo.admin.master_product_variant.store', $master),
            [
                'name' => 'White',
                'sku' => $sku,
                'state' => ProductState::ACTIVE(),
                'price' => 379.99,
            ]
        );

        $response->assertRedirect();

        $product = MasterProductVariant::findBySku($sku);
        $this->assertInstanceOf(MasterProductVariant::class, $product);
        $this->assertSame($sku, $product->sku);
        $this->assertSame('White', $product->name);
        $this->assertSame(379.99, $product->price);
    }

    #[Test]
    public function attempting_to_create_a_product_with_an_existing_sku_in_products_table_fails()
    {
        $sku = Str::ulid()->toBase58();

        Product::create([
            'name' => 'It will succeed',
            'sku' => $sku,
            'state' => ProductState::ACTIVE(),
            'price' => 100,
        ]);

        $response = $this->actingAs($this->admin)->post(
            route('vanilo.admin.product.store'),
            [
                'name' => 'It will fail',
                'sku' => $sku,
                'state' => ProductState::ACTIVE(),
                'price' => 100,
            ]
        );

        $response->assertRedirect();
        $response->assertInvalid(['sku']);
    }

    #[Test]
    public function attempting_to_create_a_variant_with_an_existing_sku_in_the_products_table_fails()
    {
        $sku = Str::ulid()->toBase58();

        Product::create([
            'name' => 'This will succeed',
            'sku' => $sku,
            'state' => ProductState::ACTIVE(),
            'price' => 100,
        ]);

        $master = MasterProduct::create([
            'name' => 'This will succeed too',
        ]);

        $response = $this->actingAs($this->admin)->post(
            route('vanilo.admin.master_product_variant.store', $master),
            [
                'name' => 'But this will fail',
                'sku' => $sku,
                'state' => ProductState::ACTIVE(),
                'price' => 379.99,
            ]
        );

        $response->assertRedirect();
        $response->assertInvalid(['sku']);
    }

    #[Test]
    public function attempting_to_create_a_product_with_an_existing_sku_in_the_variants_table_fails()
    {
        $sku = Str::ulid()->toBase58();

        $master = MasterProduct::create([
            'name' => 'A very successful master product',
        ]);

        MasterProductVariant::create([
            'master_product_id' => $master->id,
            'name' => 'in white',
            'sku' => $sku,
            'state' => ProductState::ACTIVE(),
            'price' => 100,
        ]);

        $response = $this->actingAs($this->admin)->post(
            route('vanilo.admin.product.store', $master),
            [
                'name' => 'An unsuccessful product',
                'sku' => $sku,
                'state' => ProductState::ACTIVE(),
                'price' => 379.99,
            ]
        );

        $response->assertRedirect();
        $response->assertInvalid(['sku']);
    }

    #[Test]
    public function a_product_can_be_updated_with_unmodified_sku()
    {
        $sku = Str::ulid()->toBase58();

        $product = Product::create([
            'name' => 'This will be created and updated',
            'sku' => $sku,
            'state' => ProductState::ACTIVE(),
            'price' => 100,
        ]);

        $response = $this->actingAs($this->admin)->patch(
            route('vanilo.admin.product.update', $product),
            [
                'name' => 'This will be updated',
                'sku' => $sku,
                'state' => ProductState::INACTIVE(),
            ]
        );

        $response->assertRedirect();
        $response->assertSessionDoesntHaveErrors();
    }

    #[Test]
    public function attempting_to_update_a_product_to_use_an_sku_of_another_product_fails()
    {
        $sku = Str::ulid()->toBase58();

        Product::create([
            'name' => 'This is the original one',
            'sku' => $sku,
            'state' => ProductState::ACTIVE(),
            'price' => 100,
        ]);

        $subject = Product::create([
            'name' => 'This is the test one',
            'sku' => Str::ulid()->toBase58(),
            'state' => ProductState::ACTIVE(),
            'price' => 100,
        ]);

        $response = $this->actingAs($this->admin)->patch(
            route('vanilo.admin.product.update', $subject),
            [
                'name' => 'This is the test one',
                'sku' => $sku,
                'state' => ProductState::ACTIVE(),
                'price' => 100,
            ]
        );

        $response->assertRedirect();
        $response->assertInvalid(['sku']);
    }

    #[Test]
    public function attempting_to_update_a_product_to_use_an_sku_of_an_existing_variant_fails()
    {
        $sku = Str::ulid()->toBase58();

        $master = MasterProduct::create([
            'name' => 'The Vet Horse',
        ]);

        MasterProductVariant::create([
            'master_product_id' => $master->id,
            'name' => 'of Turin',
            'sku' => $sku,
            'state' => ProductState::ACTIVE(),
            'price' => 100,
        ]);

        $subject = Product::create([
            'name' => 'Dirty Horse',
            'sku' => Str::ulid()->toBase58(),
            'state' => ProductState::ACTIVE(),
            'price' => 100,
        ]);

        $response = $this->actingAs($this->admin)->patch(
            route('vanilo.admin.product.update', $subject),
            [
                'name' => 'Dirty Horse',
                'sku' => $sku,
                'state' => ProductState::ACTIVE(),
                'price' => 100,
            ]
        );

        $response->assertRedirect();
        $response->assertInvalid(['sku']);
    }

    #[Test]
    public function a_variant_can_be_updated_with_unmodified_sku()
    {
        $sku = Str::ulid()->toBase58();

        $master = MasterProduct::create([
            'name' => 'A Good One',
        ]);

        $variant = MasterProductVariant::create([
            'master_product_id' => $master->id,
            'name' => '#2',
            'sku' => $sku,
            'state' => ProductState::ACTIVE(),
            'price' => 100,
        ]);

        $response = $this->actingAs($this->admin)->put(
            route('vanilo.admin.master_product_variant.update', [$master, $variant]),
            [
                'name' => '#2 will be updated',
                'sku' => $sku,
                'state' => ProductState::INACTIVE(),
            ]
        );

        $response->assertRedirect();
        $response->assertSessionDoesntHaveErrors();
    }

    #[Test]
    public function attempting_to_update_a_variant_to_use_an_sku_of_an_another_variant_fails()
    {
        $sku = Str::ulid()->toBase58();

        $master = MasterProduct::create([
            'name' => 'The Black Horse',
        ]);

        MasterProductVariant::create([
            'master_product_id' => $master->id,
            'name' => '#1',
            'sku' => $sku,
            'state' => ProductState::ACTIVE(),
            'price' => 100,
        ]);

        $subject = MasterProductVariant::create([
            'master_product_id' => $master->id,
            'name' => '#2',
            'sku' => Str::ulid()->toBase58(),
            'state' => ProductState::ACTIVE(),
            'price' => 100,
        ]);

        $response = $this->actingAs($this->admin)->put(
            route('vanilo.admin.master_product_variant.update', [$master, $subject]),
            [
                'name' => '#2',
                'sku' => $sku,
                'state' => ProductState::ACTIVE(),
                'price' => 100,
            ]
        );

        $response->assertRedirect();
        $response->assertInvalid(['sku']);
    }

    #[Test]
    public function attempting_to_update_a_variant_to_use_an_sku_of_an_existing_product_fails()
    {
        $sku = Str::ulid()->toBase58();

        Product::create([
            'name' => 'Za Produkt',
            'sku' => $sku,
            'state' => ProductState::ACTIVE(),
            'price' => 100,
        ]);

        $master = MasterProduct::create([
            'name' => 'The Black Horse',
        ]);

        $subject = MasterProductVariant::create([
            'master_product_id' => $master->id,
            'name' => 'Za Variant',
            'sku' => Str::ulid()->toBase58(),
            'state' => ProductState::ACTIVE(),
            'price' => 100,
        ]);

        $response = $this->actingAs($this->admin)->put(
            route('vanilo.admin.master_product_variant.update', [$master, $subject]),
            [
                'name' => '#2',
                'sku' => $sku,
                'state' => ProductState::ACTIVE(),
                'price' => 100,
            ]
        );

        $response->assertRedirect();
        $response->assertInvalid(['sku']);
    }
}
