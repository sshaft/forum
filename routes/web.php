<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();//WTF is This Routes???
Route::get('verifyEmailFirst', 'Auth\RegisterController@verifyEmailFirst')->name('verifyEmailFirst');
Route::get('verify/{email}/{verifyToken}', 'Auth\RegisterController@sendEmailDone')->name('sendEmailDone');

Route::get('/home', 'PageController@index');

//Admin Route
Route::get('admin/home', 'AdminController@index');
Route::get('admin/editor', 'EditorController@index');
Route::get('admin', 'Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('admin', 'Admin\LoginController@login');
Route::post('admin-password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin-password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin-password/reset', 'Admin\ForgotPasswordController@reset');
Route::get('admin-password/reset/{token}', 'Admin\ForgotPasswordController@showResetForm')->name('admin.password.reset');


//User Type
Route::get('profile', 'PageController@profile');

Route::post('profile', 'PostController@create');
Route::post('profile/post/delete', 'PostController@delete');
Route::post('profile/post/update', 'PostController@update');
Route::get('profile/post/search', 'PostController@search');

Route::post('upload', 'PostController@upload');

//Section
Route::post('section/create', 'SectionController@create');

Route::post('profile/upload', 'UploadController@upload');

Route::get('profile/{email}', 'PageController@users');
