<?php


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/foo', function () {
    Artisan::call('storage:link');
});

Route::any('fileExplorer', 'FileManagerController@actions');

Route::post('/admin',[\App\Http\Controllers\Web\AdminController::class,'createUser']);


Route::prefix('admin')->group(function (){
    Route::any('index/{any?}',[\App\Http\Controllers\Web\AuthController::class,'index'])->where('any', '.*');
});
