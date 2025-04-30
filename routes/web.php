<?php

use Src\Route;

Route::add('GET', '/', [Controller\Site::class, 'hello']);
Route::add('GET', '/hello', [Controller\Site::class, 'hello']);
Route::add('GET', '/subscribers', [Controller\Site::class, 'subscribers'])->middleware('auth');
Route::add('GET', '/phones', [Controller\Site::class, 'phones'])->middleware('auth');
Route::add('GET', '/rooms', [Controller\Site::class, 'rooms'])->middleware('auth');
Route::add('GET', '/departments', [Controller\Site::class, 'departments'])->middleware('auth');
Route::add('GET', '/users', [Controller\Site::class, 'users'])->middleware('auth');
Route::add(['GET', 'POST'], '/create_user', [Controller\Site::class, 'create_user'])->middleware('auth', 'admin');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);