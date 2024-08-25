<?php

declare(strict_types=1);

/**
 * Contains the Configuration component class.
 *
 * @copyright   Copyright (c) 2024 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-08-25
 *
 */

namespace Vanilo\Admin\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Nette\Schema\Elements\Structure;
use Nette\Schema\Elements\Type;
use Nette\Schema\Schema;
use ReflectionObject;
use Vanilo\Contracts\Configurable;

class Configuration extends Component
{
    public readonly bool $modelIsBeingCreated;
    public readonly bool $hasSchema;
    public readonly ?Schema $schema;
    public readonly ?array $sample;
    public readonly string $sampleAsJson;
    public readonly string $sampleAsHtml;
    public readonly string $jsid;
    public array $widgets = [];

    public function __construct(
        public readonly Configurable $model,
        public ?string $reloadOnChangeOf = null,
        public string $passOnReload = 'type',
        public ?string $sampleRefreshRoute = null,
        public ?string $label = null,
        public ?string $placeholder = null,
        public readonly string $field = 'configuration',
    ) {
        $this->label = $this->label ?? __('Configuration');
        $this->placeholder = $this->placeholder ?? __('Enter JSON config');
        $this->jsid = 'cfgI' . bin2hex(random_bytes(3));
        $this->modelIsBeingCreated = !$this->model->exists;

        if (null !== $schemaDef = $this->model->getConfigurationSchema()) {
            $this->schema = $schemaDef->getSchema();
            $this->sample = $schemaDef->getSchemaSample();
            $this->hasSchema = null !== $this->schema;
        } else {
            $this->hasSchema = false;
            $this->schema = null;
            $this->sample = null;
        }

        $this->sampleAsJson = $this->sample ? json_encode($this->sample, JSON_PRETTY_PRINT) : '{}';
        $this->sampleAsHtml = $this->sample ? Str::replace('"', '&quot;', $this->sampleAsJson) : '';
        $this->sampleRefreshRoute ??= url()->current();

        $this->initWidgets();
    }

    public function render(): View|Closure|string
    {
        return view('vanilo::components.configuration');
    }

    private function initWidgets(): void
    {
        if (!$this->hasSchema) {
            return;
        }

        return;

        //this will unlikely to stay:
        if ($this->schema instanceof Structure) {
            $items = (new ReflectionObject($this->schema))->getProperty('items');
            $items->setAccessible(true);

            foreach ($items->getValue($this->schema) as $name => $item) {
                if ($item instanceof Type) {
                    $type = (new ReflectionObject($item))->getProperty('type');
                    $type->setAccessible(true);
                    $widget = match($type->getValue($item)) {
                        'int' => "<label>$name</label><input type=\"number\" name=\"$name\" class=\"form-control form-control-sm\" />",
                        default => "<label>$name</label><input type=\"text\" name=\"$name\" class=\"form-control form-control-sm\" />"
                    };
                    $this->widgets[] = $widget;
                }
            }
        }
    }
}

