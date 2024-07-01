<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\LicenseController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['validateApiRequest']], function () {
  Route::get('/customer', [CustomerController::class, 'index']);
  Route::post('/customer/add', [CustomerController::class, 'store']);
  Route::post('/license-activate', [LicenseController::class, 'licenseActivate']);
  Route::post('/license-validate', [LicenseController::class, 'validateLicense']);  
  Route::post('/license-by-id', [LicenseController::class, 'getLicenseById']); 
  Route::post('/total-no-license', [LicenseController::class, 'getTotalLicense']);  
  Route::post('/license-validate-by-id', [LicenseController::class, 'checkLicenseValidateById']);  
  Route::post('/get-login-url', [LicenseController::class, 'loginUrl']);

});

