<?php

declare(strict_types=1);

/**
 * Contains the CreateLinkForm class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-05-29
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\CreateLinkForm as CreateLinkFormContract;
use Vanilo\Links\Contracts\LinkGroup;
use Vanilo\Links\Models\LinkGroupProxy;

class CreateLinkForm extends FormRequest implements CreateLinkFormContract
{
    use HasSourceModel;

    public static array $acceptedTypes = ['product', 'master_product', 'master_product_variant'];

    public function rules(): array
    {
        return [
            'source_type' => ['sometimes', 'nullable', 'string', Rule::in(self::$acceptedTypes)],
            'source_id' => 'required_without:link_group_id|numeric',
            'link_group_id' => 'required_without:source_id|numeric|exists:link_groups,id',
        ];
    }

    public function wantsToExtendAnExistingLinkGroup(): bool
    {
        return $this->has('link_group_id');
    }

    public function getDesiredLinkGroup(): ?LinkGroup
    {
        return $this->input('link_group_id') ?
            LinkGroupProxy::find((int) $this->input('link_group_id'))
            :
            null
        ;
    }

    public function authorize(): bool
    {
        return true;
    }
}
