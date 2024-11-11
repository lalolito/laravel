<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;

Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{id}', [studentController::class, 'show']);
Route::put('/students/{id}', [studentController::class, 'update']);
Route::delete('/students/{id}', [studentController::class, 'destroy']);

/*Route::get('/students/{id}', function ($id) {
    return 'student with id ' . $id;
});
Route::post('/students', function (Request $request) {
    return 'generate student';
});
Route::put('/students/{id}', function (Request $request, $id) {
    return 'update student';
});
Route::delete('/students/{id}', function ($id) {
    return 'student with id ' . $id;
});*/

