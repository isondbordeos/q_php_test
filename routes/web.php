<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

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

Route::get('/', [UserController::class, 'index']);

Route::post('/login', [UserController::class, 'login_auth']);

Route::get('/logout', [UserController::class, 'logout']);

Route::get('/dashboard', [UserController::class, 'dashboard']);

Route::get('/authors', [AuthorController::class, 'index']);

Route::get('/view_author/{id}', [AuthorController::class, 'view_author'])->where('id', '[0-9]+');

Route::get('/view_add_author', [AuthorController::class, 'view_add_author']);

Route::post('/create_author', [AuthorController::class, 'create_author']);

Route::get('/delete_author/{id}', [AuthorController::class, 'delete_author'])->where('id', '[0-9]+');

Route::get('/view_add_book', [BookController::class, 'index']);

Route::post('/create_book', [BookController::class, 'create_book']);

Route::get('/delete_book/{book_id}/{author_id}', [BookController::class, 'delete_book'])->where('book_id', '[0-9]+', 'author_id', '[0-9]+');



