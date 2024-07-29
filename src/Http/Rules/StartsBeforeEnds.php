<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class StartsBeforeEnds implements DataAwareRule, ValidationRule
{
    /** @var array<string, mixed> */
    protected array $data = [];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (null === $this->data['starts_at'] ?? null || null === $this->data['ends_at'] ?? null) {
            return;
        }

        if (strtotime($this->data['starts_at']) >= strtotime($this->data['ends_at'])) {
            $fail('The :attribute must be a date after the start date.')->translate();
        }
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
