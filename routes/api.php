<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\DebtsController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TreatmentClassificationController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')
    ->post('/logout', [AuthController::class, 'logout']);
Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
Route::post('/check-reset-password', [AuthController::class, 'checkResetPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);




Route::middleware('auth:sanctum')->group(function (){

    Route::prefix('users')
        ->middleware('admin')
        ->group(function (){
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'create']);
            Route::put('/{user}', [UserController::class, 'update']);
            Route::delete('/{user}', [UserController::class, 'delete']);
        });
    Route::get('/permissions', PermissionController::class)->middleware('admin');

    Route::post('/change-password', [UserController::class, 'changePassword']);

    Route::get('home', HomePageController::class);

    Route::prefix('/dates')->group(function (){
        Route::get('/', [DateController::class, 'index']);
        Route::post('/', [DateController::class, 'create'])
            ->middleware('has:dates-create');
        Route::delete('/{date}', [DateController::class, 'delete'])
            ->middleware('has:dates-delete');
    });

    Route::prefix('/diseases')->group(function (){
        Route::get('/', [DiseaseController::class, 'index']);
        Route::post('/', [DiseaseController::class, 'create'])
            ->middleware('has:diseases-create');
        Route::put('/{disease}', [DiseaseController::class, 'update'])
            ->middleware('has:diseases-update');
        Route::delete('/{disease}', [DiseaseController::class, 'delete'])
            ->middleware('has:diseases-delete');
    });

    Route::prefix('treatment-classifications')->group(function (){
        Route::get('/', [TreatmentClassificationController::class, 'index']);
        Route::post('/', [TreatmentClassificationController::class, 'create'])
            ->middleware('has:treatment-classifications-create');
        Route::get('/{treatmentClassification}', [TreatmentClassificationController::class, 'show']);
        Route::put('/{treatmentClassification}', [TreatmentClassificationController::class, 'update'])
            ->middleware('has:treatment-classifications-update');
        Route::delete('/{treatmentClassification}', [TreatmentClassificationController::class, 'delete'])
            ->middleware('has:treatment-classifications-delete');
    });

    Route::prefix('treatments')->group(function (){
        Route::get('/', [TreatmentController::class, 'index']);
        Route::post('/', [TreatmentController::class, 'create'])
            ->middleware('has:treatment-create');
        Route::put('/{treatment}', [TreatmentController::class, 'update'])
            ->middleware('has:treatment-update');
        Route::delete('/{treatment}', [TreatmentController::class, 'delete'])
            ->middleware('has:treatment-delete');
    });


    Route::prefix('/patients')->group(function (){
        Route::get('/', [PatientController::class, 'index'])
            ->middleware('has:patients-show-index');
        Route::post('/', [PatientController::class, 'create'])
            ->middleware('has:patients-create');
        Route::get('/{patient}', [PatientController::class, 'show'])
            ->middleware('has:patients-show');
        Route::middleware('admin')->group(function (){
            Route::put('/{patient}', [PatientController::class, 'update']);
            Route::delete('/{patient}', [PatientController::class, 'delete']);

            Route::post('/{patient}/diseases', [PatientController::class, 'addDisease']);
            Route::delete('/{patient}/diseases', [PatientController::class, 'deleteDisease']);

            Route::prefix('/{patient}/operations')->group(function (){
                Route::get('/{type}/{num?}', [OperationController::class, 'index']);
                Route::post('/{type}/{num?}', [OperationController::class, 'create']);
                Route::delete('/{operation}', [OperationController::class, 'delete']);
            })
                ->whereIn('type', ['plans', 'diagnosis', 'treatments'])
                ->whereIn('num', [1,2,3]);
        });

        Route::middleware('has:patients-show')
            ->prefix('/{patient}/payments')->group(function (){
            Route::get('', [PaymentController::class, 'index']);
            Route::post('', [PaymentController::class, 'create'])
                ->middleware('has:payments-create');
            Route::put('{payment}', [PaymentController::class, 'update'])
                ->middleware('has:payments-update');
            Route::delete('/{payment}', [PaymentController::class, 'delete'])
                ->middleware('has:payments-delete');
        });
    });

    Route::get('debts', DebtsController::class)
        ->middleware('has:debts-show');
});
