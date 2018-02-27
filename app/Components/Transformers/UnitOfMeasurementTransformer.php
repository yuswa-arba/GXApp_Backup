<?php

namespace App\Components\Transformers;

use App\Components\Models\UnitOfMeasurements;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class UnitOfMeasurementTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(UnitOfMeasurements $unitOfMeasurements)
    {
        return [
            'id' => $unitOfMeasurements->id,
            'format' => $unitOfMeasurements->format,
            'description' => $unitOfMeasurements->description,
            'unitOfMeasurementTypeName' => $this->getResultWithNullChecker1Connection($unitOfMeasurements,'uomType','name')
        ];
    }
}
