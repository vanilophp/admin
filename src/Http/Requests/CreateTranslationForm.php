<?php

declare(strict_types=1);

/**
 * Contains the CreateTranslationForm class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-07-21
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Konekt\AppShell\Http\Requests\HasFor;
use Vanilo\Admin\Contracts\Requests\CreateTranslationForm as CreateTranslationFormContract;

class CreateTranslationForm extends FormRequest implements CreateTranslationFormContract
{
    use HasFor;

    protected array $allowedFor = [
        'product',
        'master_product',
        'master_product_variant',
        'property',
        'property_value',
        'taxonomy',
        'taxon',
        'zone',
        'payment_method',
        'shipping_method',
        'province',
        'country',
    ];

    public function rules()
    {
        return array_merge(
            ['lang' => 'required|exists:languages,id'],
            $this->getForRules()
        );
    }

    public function getLanguage(): string
    {
        return $this->query('lang');
    }

    public function messages()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }
}
