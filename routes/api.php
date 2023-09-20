<?php

use App\Http\Controllers\api\ClassController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('class', [ClassController::class, 'index']);
Route::post('add_class', [ClassController::class, 'insert']);
Route::post('add_multiple_class', [ClassController::class, 'add_multiple_class']);
Route::post('edit_class/{id}', [ClassController::class, 'update']);
Route::put('update_user/{id}', [ClassController::class, 'updateuser']);
Route::delete('delete/{id}', [ClassController::class, 'delete']);
Route::delete('Multipledelete/{ids}', [ClassController::class, 'multipledataDelete']);
Route::delete('Multipledelete_with_json', [ClassController::class, 'multipledataDelete_with_json']);















// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
