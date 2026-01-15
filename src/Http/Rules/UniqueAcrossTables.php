<?php

declare(strict_types=1);

namespace Vanilo\Admin\Http\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UniqueAcrossTables implements ValidationRule
{
    protected array $ignore = [];

    public function __construct(
        protected array $tables,
        protected string $column
    ) {
    }

    public function ignore(string $table, string|int $id): static
    {
        $existing = $this->ignore[$table] ?? null;
        if ($existing === $id || [$id] === $existing) {
            return $this;
        }

        $this->ignore[$table] = array_unique(array_merge(Arr::wrap($existing), [$id]));

        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $column = $this->column ?? $attribute;

        foreach ($this->tables as $table) {
            $query = DB::table($table)->where($column, $value);
            if (!empty($ignore = $this->ignore[$table] ?? null)) {
                match (sizeof($ignore)) {
                    1 => $query->where('id', '!=', Arr::first($ignore)),
                    default => $query->whereNotIn('id', $ignore),
                };
            }
            if ($query->exists()) {
                $fail(__("The {$attribute} has already been taken."));

                return;
            }
        }
    }
}
