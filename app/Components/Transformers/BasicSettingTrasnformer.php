<?php

namespace App\Components\Transformers;

use League\Fractal\TransformerAbstract;

class BasicSettingTrasnformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($setting)
    {
        return [
            'id' => $setting->id,
            'name' => $setting->name,
            'value' => $setting->value,
            'description'=>$setting->description,
            'editing'=>false
        ];
    }
}
