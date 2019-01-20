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


Route::get('login' , 'BlogsController@login');
Route::get('/', 'BlogsController@index');

Auth::routes();

Route::get('/blogs' , 'BlogsController@index')->name('blogs');
Route::get('/blogs/create' , 'BlogsController@create')->name('blogs.create');
Route::post('/blogs/store' , 'BlogsController@store')->name('blogs.store');
 // Keep Trashed routes here 
Route::get('/blogs/trash' , 'BlogsController@trash')->name('blogs.trash');
Route::get('blogs/trash/{id}/restore', 'BlogsController@restore')->name('blogs.restore');
Route::delete('blogs/trash/{id}/permanent-delete' , 'BlogsController@permanentDelete')->name('blogs.permanent-delete');
Route::get('/blogs/{id}' , 'BlogsController@show')->name('blogs.show');
Route::get('/blogs/{id}/edit' , 'BlogsController@edit')->name('blogs.edit');
Route::patch('/blogs/{id}/update' , 'BlogsController@update')->name('blogs.update');
Route::delete('/blogs/{id}/delete' , 'BlogsController@delete')->name('blogs.delete');

// Admin routes 

Route::get('/dashboard' , 'AdminController@index')->name('dashboard');
Route::get('/admin/blogs' , 'AdminController@blogs')->name('admin.blogs');

// Route Resource 

Route::resource('categories','CategoryController');
Route::resource('users','UsersController');

// Contact Forms 

Route::get('contact' , 'MailController@contact')->name('contact');
Route::post('send', 'MailController@send')->name('mail.send');