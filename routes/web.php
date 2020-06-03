<?php
 /*
Route::group(['prefix' => 'user'], function () {
   
    Route::post('/register', 'UserController@register');
     Route::post('/login', 'UserController@login');
     Route::get('/view-profile','UserController@viewProfile');
     Route::get('/logout','UserController@logout');
     Route::post('/refresh-token','UserController@refreshToken');
 });
 
 
 Route::group(['prefix' => 'admin'], function () {
   
    Route::post('/register', 'AdminController@register');
     Route::post('/login', 'AdminController@login');
     Route::get('/view-profile','AdminController@viewProfile');
     Route::get('/logout','AdminController@logout');
     Route::post('/refresh-token','AdminController@refreshToken');
 });
*/

$router->group(['prefix' => 'user'], function () use ($router) {
   
    $router->post('/register', 'UserController@register');
     $router->post('/login', 'UserController@login');
     $router->get('/view-profile','UserController@viewProfile');
     $router->get('/logout','UserController@logout');
     $router->post('/refresh-token','UserController@refreshToken');
 });
 
 
 $router->group(['prefix' => 'admin'], function () use ($router) {
   
    $router->post('/register', 'AdminController@register');
     $router->post('/login', 'AdminController@login');
     $router->get('/view-profile','AdminController@viewProfile');
     $router->get('/logout','AdminController@logout');
     $router->post('/refresh-token','AdminController@refreshToken');
 });
