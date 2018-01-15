<?php

namespace App\Employee\Logics;

use App\Traits\GlobalUtils;

class ResignationLogic extends ResignationUseCase
{

    use GlobalUtils;

    public function handleProfessionalResignation($request)
    {
        // Insert data to resignation table
        // Save resignation letter
        // Deactivate employee in user table
        // Update date of resignation in employment table
        // Send email (?)
    }

    public function handleUnprofessionalResignation($request)
    {
        // Insert data to resignation table
        // Deactivate employee in user table
        // Update date of resignation in employment table
        // Send email (?)
    }
}