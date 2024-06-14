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
use Vanilo\Links\Contracts\LinkGroup;
use Vanilo\Links\Models\LinkGroupProxy;
use Vanilo\Links\Models\LinkTypeProxy;
use Vanilo\Product\Contracts\Product;

class CreateLink extends FormRequest implements CreateLinkContract
{
    use HasSourceModel;

    public function rules(): array
    {
        return [
            'link_type' => 'required_without:link_group_id|string|exclude_with:link_type_to_create|exists:link_types,slug',
            'link_type_to_create' => 'sometimes|string|min:1|max:255',
            'omnidirectional' => 'sometimes|bool',
            'link_group_id' => 'sometimes|nullable|required_without:link_type,|numeric|exists:link_groups,id',
            'source_type' => ['sometimes', 'nullable', 'string', Rule::in(CreateLinkForm::$acceptedTypes)],
            'source_id' => 'required_without:link_group_id|numeric',
            'target_type' => ['sometimes', 'nullable', 'string', Rule::in(CreateLinkForm::$acceptedTypes)],
            'target_id' => 'required|numeric',
        ];
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

    public function getDesiredLinkGroup(): ?LinkGroup
    {
        return $this->input('link_group_id') ?
            LinkGroupProxy::find((int) $this->input('link_group_id'))
            :
            null
        ;
    }

    public function wantsUnidirectionalLink(): bool
    {
        return !$this->has('omnidirectional') || !$this->input('omnidirectional');
    }

    public function wantsToAddToAnExistingGroup(): bool
    {
        return $this->has('link_group_id');
    }

    public function authorize()
    {
        return true;
    }
}
