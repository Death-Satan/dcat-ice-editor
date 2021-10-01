<?php

use Illuminate\Support\Facades\Route;


//Route::get('dcat-wang-editor', Controllers\DcatWangEditorController::class.'@index');
Route::group([
    'prefix'     => 'dcat-api',
    'namespace'  => 'SaTan\Dcat\Extensions\IceEditor\Http\Controllers',
    'as'         => 'dcat-api.',
],function (\Illuminate\Routing\Router $router){
    //视频上传接口
    $router->post('satan-ice-editor/upload/file', 'DcatIceEditorController@upload')
        ->name('satan-ice-editor.upload.file');
});
