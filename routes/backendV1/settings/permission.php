<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 6/11/17
 * Time: 5:12 PM
 */

use Illuminate\Support\Facades\Route;

Route::post('role','Permission\MainController@createRole')->name('bv1.role.create');
Route::post('permission','Permission\MainController@createPermission')->name('bv1.permission.create');