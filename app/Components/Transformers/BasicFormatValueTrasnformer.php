<?php

namespace App\Components\Transformers;

use League\Fractal\TransformerAbstract;

class BasicFormatValueTrasnformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($component)
    {
        return [
            'id' => $component->id,
            'format' => $component->format,
            'value' => $component->value,
        ];
    }
}
