<?php

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\API\AttendanceController as AppAttendanceController;
use App\Http\Controllers\API\BillingController;
use App\Http\Controllers\API\GIGOController;
use App\Http\Controllers\API\InboxController;
use App\Http\Controllers\API\OpenTicketController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\InspectionController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\WorkOrderController;
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

        // Unit
        Route::get('/units', [UnitController::class, 'getAllUnits']);

        // Open Ticket
        Route::get('/tickets', [OpenTicketController::class, 'listTickets']);
        Route::get('/jenis-request', [OpenTicketController::class, 'jenisRequest']);
        Route::get('/tenant-unit', [UnitController::class, 'tenantUnit']);
        Route::post('/open-ticket', [OpenTicketController::class, 'store']);
        Route::get('/open-ticket/{id}', [OpenTicketController::class, 'show']);
        Route::get('/payable-tickets/{id}', [OpenTicketController::class, 'payableTickets']);

        // Work Order
        Route::get('/work-order/{id}', [WorkOrderController::class, 'show']);
        Route::get('/accept/work-order/{id}', [WorkOrderController::class, 'acceptWO']);
        Route::post('/generate/payment-wo/{id}', [WorkOrderController::class, 'generatePaymentWO']);
        Route::get('/show/billing/{id}', [WorkOrderController::class, 'showBilling']);

        // Billing
        Route::get('/list-billings/{id}', [BillingController::class, 'listBillings']);
        Route::get('/get-billing/{id}', [BillingController::class, 'showBilling']);
        Route::post('/create-transaction/{id}', [BillingController::class, 'generateTransaction']);
        Route::get('/list-banks', [BillingController::class, 'listBank']); // List all available bank

        Route::post('get/admin-fee', [BillingController::class, 'adminFee']);

        // Inspection Eng
        Route::get('/inspectioneng', [InspectionController::class, 'checklistengineering']);
        Route::get('/inspection-engineering-history/{id}', [InspectionController::class, 'showHistoryEngineering']);
        Route::get('/inspectioneng-schedule', [InspectionController::class, 'schedueinspection']);
        Route::post('/inspection-engineering', [InspectionController::class, 'storeinspectionEng']);
        Route::get('/equipment-engineering/{id}', [InspectionController::class, 'showEngineering']);
        // Inspection HK
        Route::get('/inspection-hk', [InspectionController::class, 'checklisthousekeeping']);
        Route::get('/inspection-hk-schedule', [InspectionController::class, 'schedueinspectionhk']);
        Route::post('/inspection-housekeeping', [InspectionController::class, 'storeinspectionHK']);
        Route::get('/equipment-housekeeping/{id}', [InspectionController::class, 'showHousekeeping']);

        // Inbox
        Route::get('/inboxes', [InboxController::class, 'index']);

        // GIGO
        Route::get('/gigo/{id}', [GIGOController::class, 'show']);
        Route::post('/gigo/add/{id}', [GIGOController::class, 'addGood']);
        Route::post('/gigo/remove/{id}', [GIGOController::class, 'removeGood']);
        Route::post('/gigo/{id}', [GIGOController::class, 'update']);

        // Attendance
        Route::post('/attendance/checkin/{token}', [AppAttendanceController::class, 'checkin']);
        Route::post('/attendance/checkout/{token}', [AppAttendanceController::class, 'checkout']);

        // Package
        Route::post('/package', [PackageController::class, 'store']);
        Route::get('/package/unit/{id}', [PackageController::class, 'packageByUnit']);
        Route::get('/package/{id}', [PackageController::class, 'showPackage']);
        Route::post('/pickup/package/{id}/{token}', [PackageController::class, 'pickupPackage']);
    });
});
