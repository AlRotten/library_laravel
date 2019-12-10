<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/*------ BOOKS_USERS ------*/

//POST
Route::middleware('auth:api')->post('/service', 'ServiceController@deliveryOneBook');
Route::middleware('auth:api')->put('/service', 'ServiceController@returnOneBook');

/*------ BOOKS ------*/

//GET
Route::get('/books/all', 'BooksController@getBooks');
Route::get('/books/{id}', 'BooksController@getOneBook');
Route::get('/books', 'BooksController@getBooksByString');

//POST
Route::middleware('auth:api')->post('/books', 'BooksController@createBook');

//PUT
Route::middleware('auth:api')->put('/books', 'BooksController@modifyBook');

//DELETE
Route::middleware('auth:api')->delete('/books', 'BooksController@deleteBook');

/*------ USERS ------*/

//GET
Route::middleware('auth:api')->get('/users/all', 'UsersController@getUsers');
Route::middleware('auth:api')->get('/users/{id}', 'UsersController@getOneUser');

//POST
Route::post('/users', 'UsersController@createUser');

//PUT
Route::middleware('auth:api')->put('/users', 'UsersController@modifyUser');

//DELETE
Route::middleware('auth:api')->delete('/users', 'UsersController@deleteUser');
