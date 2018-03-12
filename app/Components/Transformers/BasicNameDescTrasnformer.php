<?php

namespace App\Components\Transformers;

use League\Fractal\TransformerAbstract;

class BasicNameDescTrasnformer extends TransformerAbstract
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
            'description' => $component->description,
        ];
    }
}
