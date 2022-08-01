<?php



use Illuminate\Support\Facades\Artisan;

Route::group(['namespace' => 'Genrator'], function () {
    Route::get('htmlpdf','PDFController@htmlPDF');
});
Route::get('/foo', function () {
    Artisan::call('storage:link');
});