<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("/offer/offers", [OfferController::class, 'public_index']);

Route::resource("/company", CompanyController::class)->only(['index', "show"]);;
Route::get("/company/{companyId}/offer", [OfferController::class, 'getCompanyOffers']);



Route::get("/tag", [TagController::class, 'publicIndex']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route::get('/offer', [OfferController::class, 'indexAuthenticated']);
    // Route::get('/offer/{offer}', [OfferController::class, 'showAuthenticated']);
    Route::resource("/offer", OfferController::class)->except(['index', "show"]);;
    Route::resource("/company", CompanyController::class)->except(['index', "show"]);;
    Route::post("/logout", [AuthController::class, 'logout']);
    Route::get("/application/company", [ApplicationController::class, 'companyApplications']);
    Route::get("/application/application", [ApplicationController::class, 'myApplications']);
    Route::get("/application/{application}/resume", [ApplicationController::class, 'getPdf']);
    Route::resource("/application", ApplicationController::class);
});

Route::middleware('guard')->group(function () {
    Route::resource("/offer", OfferController::class)->only(['index', "show"]);
});

Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);
// Route::post("/logout", [AuthController::class, 'logout']);