<?php
use Illuminate\Support\Facades\Route;
use App\Http\Components\com_taskflow\ComDefinitions;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;



Route::prefix(ComDefinitions::$com_name)->group(function(){

    Route::get('/', function () {
        //return view('welcome');
        
        return view(ComDefinitions::getViewPath() . '.index');
    })->name(ComDefinitions::$com_name );

    Route::get('/index', function () {
        //return view('welcome');
        
        return view(ComDefinitions::getViewPath() . '.index');
    })->name(ComDefinitions::$com_name . ".index");

    Route::get('/calendar', function () {
        //return view('welcome');
        return view(ComDefinitions::getViewPath()  . '.calendar');
    })->name(ComDefinitions::$com_name . ".calendar");
    
    
    Route::get('/boards', function () {
        return view(ComDefinitions::getViewPath()  . '.boards');
    })->name(ComDefinitions::$com_name . ".boards");


    Route::get('/board', function () {
        return view(ComDefinitions::getViewPath()  . '.board');
    })->name(ComDefinitions::$com_name . ".board");


    Route::get('/settings', function () {
        return view(ComDefinitions::getViewPath()  . '.settings');
    })->name(ComDefinitions::$com_name . ".settings");

});
