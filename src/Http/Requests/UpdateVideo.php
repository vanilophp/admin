<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vanilo\Admin\Contracts\Requests\UpdateVideo as UpdateVideoContract;

class UpdateVideo extends FormRequest implements UpdateVideoContract
{
    protected $errorBag = 'video';

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'reference' => 'required|string|max:255',
            'is_published' => 'sometimes|boolean',
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
