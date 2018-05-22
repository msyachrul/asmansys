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

Auth::routes();

Route::get('/', function () {
    return view('admin.dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/home', function () {
	return view('admin.home');
});

Route::get('/asset', function () {
	return view('admin.asset');
})->name('assets');

Route::resource('/menu/asset','assetController');
Route::get('/menu/asset/document/{asset}','assetController@integrationShow')->name('asset.integrationShow');
Route::post('/menu/asset/document/{asset}/store','assetController@integrationStore')->name('asset.integrationStore');
Route::post('/menu/asset/document/delete','assetController@integrationDestroy')->name('asset.integrationDestroy');

Route::resource('/menu/category','categoryController');

Route::resource('/menu/region','regionController');

Route::resource('/menu/certificate','certificateController');

Route::resource('/menu/user','userController');

Route::get('/asset','assetController@userIndex')->name('asset.userIndex');

Route::get('/asset/{asset}','assetController@userShow')->name('asset.userShow');

Route::get('/certificate','certificateController@userIndex')->name('certificate.userIndex');

Route::get('/certificate/{certificate}','certificateController@userShow')->name('certificate.userShow');

Route::get('/category','categoryController@userIndex')->name('category.userIndex');

Route::get('/category/{category}','categoryController@userShow')->name('category.userShow');

Route::get('/region','regionController@userIndex')->name('region.userIndex');

Route::get('/region/{region}','regionController@userShow')->name('region.userShow');

Route::get('/home', 'HomeController@index')->name('home');
