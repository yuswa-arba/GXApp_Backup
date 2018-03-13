<?php

namespace App\Storage\Transformers;

use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class BasicCodeNameTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform($data)
    {
        return [
            'code' => $data->code,
            'name' => $data->name,
            'isDeleted'=>$data->isDeleted,
            'editing'=>false
        ];
    }
}
