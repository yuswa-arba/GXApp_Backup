<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 9/23/17
 * Time: 1:18 AM
 */

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Str;

class EloquentAdminUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        // Of course here, you could perform the query yourself with the isAdmin comparison, but
        // I think it's best to avoid as much duplication as possible
        $user = parent::retrieveByCredentials($credentials);

        return $user && $user->allowAdminAccess === false ? null : $user;
    }
}