<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 31/10/17
 * Time: 9:26 AM
 */


use Illuminate\Support\Facades\Route;

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


