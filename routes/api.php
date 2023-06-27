<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApplicationsController;
use App\Http\Controllers\TypeApplicationController;
use App\Http\Controllers\NameApplicationController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::prefix('applications')->group(function () {
            Route::get('/inJob/{id}', [ApplicationsController::class, 'indexInJob']);
            Route::get('/userApplications/{id}', [ApplicationsController::class, 'userApplications']);
            Route::get('/', [ApplicationsController::class, 'index']);
            Route::post('/', [ApplicationsController::class, 'create']);
            Route::put('/', [ApplicationsController::class, 'edit']);
            Route::delete('/{id}', [ApplicationsController::class, 'destroy']);
            Route::put('/accept',[ApplicationsController::class,'acceptApp']);
            Route::put('/rejection',[ApplicationsController::class,'rejection']);
            Route::put('/complete',[ApplicationsController::class,'complete']);

            Route::post('/report', [ApplicationsController::class, 'report']);
            Route::post('/exportJson',[ApplicationsController::class,'jsonGET']);
            Route::post('/csvGET',[ApplicationsController::class,'csvGET']);
        });

        Route::prefix('priorities')->group(function () {
            Route::get('/', [PriorityController::class, 'index']);
        });

        Route::prefix('typeapplications')->group(function () {
            Route::get('/', [TypeApplicationController::class, 'index']);
        });

        Route::prefix('nameapplications')->group(function () {
            Route::get('/', [NameApplicationController::class, 'index']);
        });

        Route::prefix('statuses')->group(function () {
            Route::get('/', [StatusController::class, 'index']);
        });

        Route::prefix('users')->group(function () {
            Route::get('/initiators', [UserController::class, 'initiators']);
            Route::get('/employees', [UserController::class, 'employees']);

        });
    });
});


Route::prefix('user')->group(function () {
    Route::post('/create', [UserController::class, 'create']);
    Route::get('/', [ApplicationsController::class, 'index']);
    Route::get('/julia', [ApplicationsController::class,'julia']);
    Route::get('/juliaTry', [ApplicationsController::class,'juliaTry']);
    Route::get('/juliaOpenMobile', [ApplicationsController::class,'juliaOpenMobile']);
    Route::get('/juliaOpenPc', [ApplicationsController::class,'juliaOpenPc']);

});


