<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return Redirect::route('users/login');
});

 
Route::get("/login", array(
		"as"   => "users/login",
		"uses" => "UsersController@getLogin"
	)
);

Route::post("/login", array(
		"as"   => "users/login",
		"uses" => "UsersController@postLogin"
	)
);

Route::get("/request", [
 "as" => "users/request",
 "uses" => "UsersController@getRequest"
]);

Route::post("/request", [
 "as" => "users/request",
 "uses" => "UsersController@postRequest"
]);
 
Route::get("/reset/{token}", [
 "as" => "users/reset",
 "uses" => "UsersController@getReset"
]);

Route::post("/reset/{token}", [
 "as" => "users/reset",
 "uses" => "UsersController@postReset"
]);

Route::group(["before" => "auth"], function() {
 
  Route::any("/profile", [
    "as"   => "users/profile",
    "uses" => "UsersController@getProfile"
  ]);
 
});
Route::any("/logout", [
  "as"   => "users/logout",
  "uses" => "UsersController@logout"
]);