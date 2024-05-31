<?php

declare(strict_types=1);

/**
 * Contains the CreateLink class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-05-29
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\CreateLink as CreateLinkContract;
use Vanilo\Links\Models\LinkTypeProxy;
use Vanilo\Product\Contracts\Product;

class CreateLink extends FormRequest implements CreateLinkContract
{
    use HasSourceModel;

    public function rules(): array
    {
        return [
            'link_type' => 'required|string|exclude_with:link_type_to_create|exists:link_types,slug',
            'link_type_to_create' => 'sometimes|string|min:1|max:255',
            'source_type' => ['sometimes', 'nullable', 'string', Rule::in(CreateLinkForm::$acceptedTypes)],
            'source_id' => 'required|numeric',
            'target_type' => ['sometimes', 'nullable', 'string', Rule::in(CreateLinkForm::$acceptedTypes)],
            'target_id' => 'required|numeric',
        ];
    }

    public function urlOfModel(Model $model): ?string
    {
        return match (true) {
            is_master_product($model) => route('vanilo.admin.master_product.show', $model),
            is_master_product_variant($model) => route('vanilo.admin.master_product_variant.edit', [$model->masterProduct, $model]),
            $model instanceof Product => route('vanilo.admin.product.show', $model),
            default => null,
        };
    }

    public function getTargetModel(): ?Model
    {
        if (null === $class = $this->resolveModelClass($this->input('target_type'))) {
            return null;
        }

        return $class::find($this->input('target_id'));
    }

    public function getLinkType(): string
    {
        if ($this->has('link_type_to_create')) {
            $linkType = LinkTypeProxy::create([
                'name' => $this->input('link_type_to_create'),
                'is_active' => true,
            ]);

            return $linkType->slug;
        }

        return $this->input('link_type');
    }

    public function authorize()
    {
        return true;
    }
}
