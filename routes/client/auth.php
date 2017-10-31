<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 31/10/17
 * Time: 9:26 AM
 */


use Illuminate\Support\Facades\Route;

Route::get('login',function (){
   return view('pages.auth.login');
})->name('login');

Route::get('logout',function (){
   return view('pages.auth.login');
})->name('logout');