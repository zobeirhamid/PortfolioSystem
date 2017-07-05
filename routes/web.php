<?php
Route::get('/admin/{vue_capture?}', function () {
    return view('admin');
})->where('vue_capture', '[\/\w\.-]*');

Route::get('/{vue_capture?}', function () {
    return view('index');
})->where('vue_capture', '[\/\w\.-]*');

