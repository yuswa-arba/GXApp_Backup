<?php

namespace App\Components\Transformers;

use App\Components\Models\Division;
use App\Components\Models\JobPosition;
use League\Fractal\TransformerAbstract;

class DivisionListTransfomer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Division $division)
    {
        return [
            'id' => $division->id,
            'name' => $division->name,
        ];
    }
}
