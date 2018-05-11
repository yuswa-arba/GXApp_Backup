<?php

namespace App\Components\Transformers;

use App\Components\Models\CompanyNPWP;
use League\Fractal\TransformerAbstract;

class NPWPTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(CompanyNPWP $companyNPWP)
    {
        return [
            'id' => $companyNPWP->id,
            'npwpNo' => $companyNPWP->npwpNo,
            'companyName' => $companyNPWP->companyName,
            'companyAddress' => $companyNPWP->companyAddress,
            'dateRegistered' => $companyNPWP->dateRegistered,
            'npwpPhoto' => $companyNPWP->npwpPhoto,
        ];
    }
}
