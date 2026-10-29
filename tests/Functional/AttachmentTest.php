<?php

declare(strict_types=1);

namespace Vanilo\Admin\Tests\Functional;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Vanilo\Foundation\Models\MasterProduct;
use Vanilo\Foundation\Models\MasterProductVariant;
use Vanilo\Foundation\Models\Product;
use Vanilo\Product\Models\ProductState;

class AttachmentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        config(['media-library.disk_name' => 'public']);
    }

    #[Test]
    public function attachments_can_be_uploaded_to_a_product()
    {
        $product = $this->createProduct();

        $response = $this->actingAs($this->admin)->post(route('vanilo.admin.attachment.store'), [
            'for' => 'product',
            'forId' => $product->id,
            'attachments' => [
                UploadedFile::fake()->create('manual.pdf', 120, 'application/pdf'),
                UploadedFile::fake()->create('specs.xlsx', 12),
            ],
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $product = $product->fresh();
        $this->assertEquals(2, $product->attachmentCount());
        $this->assertEquals(0, $product->imageCount());
        $this->assertEquals(['manual.pdf', 'specs.xlsx'], $product->getAttachments()->pluck('file_name')->all());
    }

    #[Test]
    public function attachments_can_be_uploaded_to_a_master_product_and_to_a_variant()
    {
        $master = MasterProduct::create(['name' => 'Kosmo Chair']);
        $variant = MasterProductVariant::create(['master_product_id' => $master->id, 'sku' => 'KOSMO-RED', 'name' => 'Kosmo Chair Red']);

        $this->actingAs($this->admin)->post(route('vanilo.admin.attachment.store'), [
            'for' => 'master_product',
            'forId' => $master->id,
            'attachments' => [UploadedFile::fake()->create('assembly.pdf', 50, 'application/pdf')],
        ])->assertSessionHasNoErrors();

        $this->actingAs($this->admin)->post(route('vanilo.admin.attachment.store'), [
            'for' => 'master_product_variant',
            'forId' => $variant->id,
            'attachments' => [UploadedFile::fake()->create('color-chart.pdf', 50, 'application/pdf')],
        ])->assertSessionHasNoErrors();

        $this->assertEquals('assembly.pdf', $master->fresh()->getAttachments()->first()->file_name);
        $this->assertEquals('color-chart.pdf', $variant->fresh()->getAttachments()->first()->file_name);
    }

    #[Test]
    public function disallowed_file_types_are_rejected()
    {
        $product = $this->createProduct();

        $response = $this->actingAs($this->admin)->post(route('vanilo.admin.attachment.store'), [
            'for' => 'product',
            'forId' => $product->id,
            'attachments' => [UploadedFile::fake()->create('evil.php', 1)],
        ]);

        $response->assertSessionHasErrors('attachments.0');
        $this->assertFalse($product->fresh()->hasAttachments());
    }

    #[Test]
    public function attachments_can_only_be_added_to_supported_models()
    {
        $product = $this->createProduct();

        $response = $this->actingAs($this->admin)->post(route('vanilo.admin.attachment.store'), [
            'for' => 'taxonomy',
            'forId' => $product->id,
            'attachments' => [UploadedFile::fake()->create('manual.pdf', 1)],
        ]);

        $response->assertSessionHasErrors('for');
    }

    #[Test]
    public function an_attachment_can_be_deleted()
    {
        $product = $this->createProduct();
        $product->addAttachment(UploadedFile::fake()->create('manual.pdf', 120, 'application/pdf'));
        $attachment = $product->fresh()->getAttachments()->first();

        $response = $this->actingAs($this->admin)->delete(route('vanilo.admin.attachment.destroy', $attachment));

        $response->assertRedirect();
        $this->assertFalse($product->fresh()->hasAttachments());
    }

    #[Test]
    public function images_can_not_be_deleted_via_the_attachment_route()
    {
        $product = $this->createProduct();
        $image = $product->addMedia(__DIR__ . '/../img/vanilo_640.png')->preservingOriginal()->toMediaCollection();

        $response = $this->actingAs($this->admin)->delete(route('vanilo.admin.attachment.destroy', $image));

        $response->assertNotFound();
        $this->assertEquals(1, $product->fresh()->imageCount());
    }

    #[Test]
    public function attachments_are_listed_on_the_product_edit_and_show_pages()
    {
        $product = $this->createProduct();
        $product->addAttachment(UploadedFile::fake()->create('user-guide.pdf', 120, 'application/pdf'));

        $this->actingAs($this->admin)->get(route('vanilo.admin.product.edit', $product))
            ->assertOk()
            ->assertSee('Attachments')
            ->assertSee('user-guide.pdf');

        $this->actingAs($this->admin)->get(route('vanilo.admin.product.show', $product))
            ->assertOk()
            ->assertSee('Attachments')
            ->assertSee('user-guide.pdf');
    }

    private function createProduct(): Product
    {
        return Product::create([
            'name' => 'Kosmo Chair',
            'sku' => 'KOSMO-' . uniqid(),
            'state' => ProductState::ACTIVE(),
        ]);
    }
}
