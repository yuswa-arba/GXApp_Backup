<?php

namespace App\Fingerspot\Transformers;

use App\Components\Models\CompanyNPWP;
use App\Fingerspot\Model\FingerspotDevice;
use League\Fractal\TransformerAbstract;

class FingerspotDeviceListTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(FingerspotDevice $fingerspotDevice)
    {
        return [
            'id'=>$fingerspotDevice->id,
            'server_ip'=>$fingerspotDevice->server_ip,
            'server_port'=>$fingerspotDevice->server_port,
            'device_sn'=>$fingerspotDevice->device_sn,
            'is_activated'=>$fingerspotDevice->is_activated,
            'description'=>$fingerspotDevice->description,
            'editing'=>false
        ];
    }
}
