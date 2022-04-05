<?php

namespace Vanilo\Admin\Tests\Functional;

use Vanilo\Foundation\Models\Product;
use Vanilo\Product\Models\ProductState;

class ProductCRUDTest extends TestCase
{
    /** @test */
    public function it_can_list_active_products()
    {
        $productA = Product::create([
            'name'  => 'Audi A4',
            'sku'   => 'AUD-A4',
            'state' => ProductState::ACTIVE(),
            'price' => 11500
        ]);

        $productB = Product::create([
            'name'  => 'BMW M3',
            'sku'   => 'BMW-F31',
            'state' => ProductState::ACTIVE(),
            'price' => 14500
        ]);

        $productC = Product::create([
            'name'  => 'Daewoo Tico',
            'sku'   => 'DWO-TICO',
            'state' => ProductState::ACTIVE(),
            'price' => 1500
        ]);

        $response = $this->actingAs($this->admin)->get(route('vanilo.admin.product.index'));

        $response->assertOk();

        $response->assertSee('Audi A4');
        $response->assertSee('BMW M3');
        $response->assertSee('Daewoo Tico');

        $response->assertSee($productA->sku);
        $response->assertSee($productB->sku);
        $response->assertSee($productC->sku);
    }

    /** @test */
    public function it_can_list_only_active_products()
    {
       Product::create([
            'name'  => 'Audi A3',
            'sku'   => 'AUD-A3',
            'state' => ProductState::ACTIVE(),
            'price' => 15500
        ]);

        Product::create([
            'name'  => 'BMW x6',
            'sku'   => 'BMW-F31',
            'price' => 22000
        ]);

        $response = $this->actingAs($this->admin)->get(route('vanilo.admin.product.index'));

        $response->assertOk();

        $response->assertSee('Audi A3');
        $response->assertDontSee('BMW X6');
    }

    /** @test */
    public function the_new_product_form_can_be_displayed()
    {
        $response = $this->actingAs($this->admin)->get(route('vanilo.admin.product.create'));

        $response->assertOk();
        $response->assertSee('Product Details');
        $response->assertSee('State');
        foreach (ProductState::labels() as $state) {
            $response->assertSee($state);
        }

        $response->assertSee('Description');
        $response->assertSee('Create product');
    }

    /** @test */
    public function the_product_edit_form_can_be_displayed()
    {
        $product = Product::create([
            'name'  => 'Netgear LB 2120',
            'sku'   => '115278447875',
            'state' => ProductState::ACTIVE(),
            'price' => 197,
            'description' => 'Simple, Fail-safe Connectivity.'
        ]);

        $response = $this->actingAs($this->admin)->get(route('vanilo.admin.product.edit', $product));

        $response->assertOk();
        $response->assertSee('Product Data');
        $response->assertSee('State');
        $response->assertSee('Netgear LB 2120');
        $response->assertSee('115278447875');
        $response->assertSee('Simple, Fail-safe Connectivity.');
        foreach (ProductState::labels() as $state) {
            $response->assertSee($state);
        }

        $response->assertSee('Description');
        $response->assertSee('Save');
    }

    /** @test */
    public function a_product_can_be_deleted()
    {
        $product = Product::create([
            'name'  => '4G LTE Mobile Hotspot (AC797)',
            'sku'   => '552919920',
            'state' => ProductState::ACTIVE(),
            'price' => 179,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('vanilo.admin.product.destroy', $product));

        $response->assertRedirect(route('vanilo.admin.product.index'));
    }
}
