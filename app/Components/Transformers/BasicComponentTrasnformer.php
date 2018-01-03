<?php

namespace App\Components\Transformers;

use League\Fractal\TransformerAbstract;

class BasicComponentTrasnformer extends TransformerAbstract
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
            'name' => $component->name,
        ];
    }
}
