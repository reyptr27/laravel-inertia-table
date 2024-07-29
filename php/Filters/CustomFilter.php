<?php

namespace ReyPtr27\LaravelQueryBuilderInertiaJs\Filters;

use Illuminate\Contracts\Support\Arrayable;

class CustomFilter implements Arrayable, Filterable
{
    protected const TYPE = 'custom';

    public function __construct(
        public string $key,
        public string $label,
        public $value = null,
        public array $params = [],
    ) {}

    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'label' => $this->label,
            'value' => $this->value,
            'type' => self::TYPE,
            'params' => $this->params,
        ];
    }
}
