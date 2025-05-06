<?php

use Src\Route;

Route::add('GET', '/', [Controller\Site::class, 'hello']);
Route::add('GET', '/hello', [Controller\Site::class, 'hello']);
Route::add('GET', '/subscribers', [Controller\Site::class, 'subscribers'])->middleware('auth');
Route::add('GET', '/subscriber/{id}', [Controller\Site::class, 'subscriber'])->middleware('auth');
Route::add('GET', '/phones', [Controller\Site::class, 'phones'])->middleware('auth');
Route::add('GET', '/rooms', [Controller\Site::class, 'rooms'])->middleware('auth');
Route::add('GET', '/departments', [Controller\Site::class, 'departments'])->middleware('auth');
Route::add('GET', '/users', [Controller\Site::class, 'users'])->middleware('auth');
Route::add(['GET', 'POST'], '/create_user', [Controller\Site::class, 'create_user'])->middleware('auth', 'admin');
Route::add(['GET', 'POST'], '/departments/create', [Controller\Site::class, 'create_department'])->middleware('auth');
Route::add(['GET', 'POST'], '/department_types/create', [Controller\Site::class, 'create_department_type'])->middleware('auth');
Route::add(['GET', 'POST'], '/rooms/create', [Controller\Site::class, 'create_room'])->middleware('auth');
Route::add(['GET', 'POST'], '/room_types/create', [Controller\Site::class, 'create_room_type'])->middleware('auth');
Route::add(['GET', 'POST'], '/subscribers/create', [Controller\Site::class, 'create_subscriber'])->middleware('auth');
Route::add(['GET', 'POST'], '/subscribers/count', [Controller\Site::class, 'count_subscribers'])->middleware('auth');
Route::add(['GET', 'POST'], '/phones/create', [Controller\Site::class, 'create_phone'])->middleware('auth');
Route::add(['GET', 'POST'], '/attach_phone', [Controller\Site::class, 'attach_phone'])->middleware('auth');
Route::add(['GET', 'POST'], '/detach_phone/{id}', [Controller\Site::class, 'detach_phone'])->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);