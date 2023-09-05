<?php

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\API\BillingController;
use App\Http\Controllers\API\OpenTicketController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\InspectionController;
use App\Http\Controllers\PaymentController;
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

Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        return ResponseFormatter::success('PRO APPS API V1');
    });
    Route::get('sites', [SiteController::class, 'sites']);
    Route::post('/login', [UserController::class, 'login'])->name('api-login');

    // Insert electric meter
    Route::get('/insert-electric/{unitID}/{token}', [BillingController::class, 'insertElectricMeter']);
    Route::get('store/insert-electric/{unitID}/{token}', [BillingController::class, 'storeElectricMeter'])->name('store-usr-electric');

    // Insert water meter
    Route::get('/insert-water/{unitID}/{token}', [BillingController::class, 'insertWaterMeter']);
    Route::get('/store/insert-water/{unitID}/{token}', [BillingController::class, 'storeWaterMeter'])->name('store-usr-water');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('get/cc-token', [BillingController::class, 'getTokenCC']);

        Route::get('/user', [UserController::class, 'user'])->name('user');

        Route::post('/select-role', [UserController::class, 'selectRole']);

        Route::get('/invoice/{id}', [PaymentController::class, 'invoiceAPI']);

        // Open Ticket
        Route::get('/tickets', [OpenTicketController::class, 'listTickets']);
        Route::get('/jenis-request', [OpenTicketController::class, 'jenisRequest']);
        Route::get('/tenant-unit', [UnitController::class, 'tenantUnit']);
        Route::post('/open-ticket', [OpenTicketController::class, 'store']);
        Route::get('/open-ticket/{id}', [OpenTicketController::class, 'show']);

        // Billing
        Route::get('/list-billings/{id}', [BillingController::class, 'listBillings']);
        Route::get('/get-billing/{id}', [BillingController::class, 'showBilling']);
        Route::post('/create-transaction/{id}', [BillingController::class, 'generateTransaction']);
        Route::get('/list-banks', [BillingController::class, 'listBank']); // List all available bank

        Route::post('get/admin-fee', [BillingController::class, 'adminFee']);

        // Inspection
        Route::get('/inspectioneng', [InspectionController::class, 'checklistengineering']);
    });
});
