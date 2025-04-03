<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vanilo\Admin\Contracts\Requests\UpdateVideo as UpdateVideoContract;
use Vanilo\Video\VideoDrivers;

class UpdateVideo extends FormRequest implements UpdateVideoContract
{
    protected $errorBag = 'updateVideo';

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'driver' => ['required', 'string', 'max:255', Rule::in(VideoDrivers::ids())],
            'reference' => 'required|string|max:255',
            'is_published' => 'sometimes|boolean',
        ];
    }

    public function authorize(): true
    {
        return true;
    }

    protected function getValidatorInstance()
    {
        $this->errorBag .= (string) $this->route('video')->hash;

        return parent::getValidatorInstance();
    }
}
