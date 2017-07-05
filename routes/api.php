<?php

use Illuminate\Http\Request;

Route::post('/login', 'AuthController@login');

Route::get('/test', function() {
    return 'Authenticated';
})->middleware('auth:api');

Route::get('/projects', 'ProjectsController@index');
Route::get('/projects/sticky', 'ProjectsController@sticky');
Route::get('/projects/{project}', 'ProjectsController@show');
Route::post('/projects', 'ProjectsController@store');

Route::put('/projects/{project}', 'ProjectsController@update');
Route::delete('/projects/{project}', 'ProjectsController@destroy');

Route::get('/categories', 'TagsController@index');
Route::get('/categories/{tag}', 'TagsController@show');

Route::post('/links', 'LinksController@store');
Route::put('/links/{link}', 'LinksController@update');
Route::delete('/links/{link}', 'LinksController@destroy');
Route::get('/links', 'LinksController@index');
Route::get('/links/{link}', 'LinksController@show');
