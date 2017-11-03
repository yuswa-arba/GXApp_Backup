<?php

namespace App\Policies;

use App\Account\Models\User;
use App\Employee\Models\MasterEmployee;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the masterEmployee.
     *
     * @param  \App\Account\Models\User  $user
     * @param  \App\Employee\Models\MasterEmployee $masterEmployee
     * @return mixed
     */
    public function view(User $user, MasterEmployee $masterEmployee)
    {
        //
    }

    /**
     * Determine whether the user can create masterEmployees.
     *
     * @param  \App\Account\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $access = ($user->allowAdminAccess || $user->allowSuperAdminAccess);
        return $access;
    }

    /**
     * Determine whether the user can update the masterEmployee.
     *
     * @param  \App\Account\Models\User  $user
     * @param  \App\Employee\Models\MasterEmployee $masterEmployee
     * @return mixed
     */
    public function update(User $user, MasterEmployee $masterEmployee)
    {
        return $user->id === $masterEmployee->employeeId;
    }

    /**
     * Determine whether the user can delete the masterEmployee.
     *
     * @param  \App\Account\Models\User  $user
     * @param \App\Employee\Models\MasterEmployee
     * @return mixed
     */
    public function delete(User $user, MasterEmployee $masterEmployee)
    {
        $access = ($user->allowAdminAccess || $user->allowSuperAdminAccess);
        return $access;
    }
}
