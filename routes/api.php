<?php

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\BillingController;
use App\Http\Controllers\API\GIGOController;
use App\Http\Controllers\API\InboxController;
use App\Http\Controllers\API\IncidentalController;
use App\Http\Controllers\API\OpenTicketController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\InspectionController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\ToolsController;
use App\Http\Controllers\API\VisitorController;
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
        Route::get('/water-usage-record/{unitID}', [UnitController::class, 'waterUsageRecord']);
        Route::get('/electric-usage-record/{unitID}', [UnitController::class, 'electricUsageRecord']);

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
        Route::post('/inspection-engineering/{id}', [InspectionController::class, 'storeinspectionEng']);
        Route::get('/equipment-engineering/{id}', [InspectionController::class, 'showEngineering']);

        // Inspection HK showHistoryHK
        Route::get('/inspection-hk', [InspectionController::class, 'checklisthousekeeping']);
        Route::get('/inspection-hk-history/{id}', [InspectionController::class, 'showHistoryHK']);
        Route::get('/inspection-hk-schedule', [InspectionController::class, 'schedueinspectionhk']);
        Route::post('/inspection-housekeeping/{id}', [InspectionController::class, 'storeinspectionHK']);
        Route::get('/equipment-housekeeping/{id}', [InspectionController::class, 'showHousekeeping']);

        // Inbox
        Route::get('/inboxes', [InboxController::class, 'index']);

        // GIGO
        Route::get('/gigo/{id}', [GIGOController::class, 'show']);
        Route::post('/gigo/add/{id}', [GIGOController::class, 'addGood']);
        Route::post('/gigo/remove/{id}', [GIGOController::class, 'removeGood']);
        Route::post('/gigo/{id}', [GIGOController::class, 'update']);

        // Attendance
        Route::get('/site-location', [AttendanceController::class, 'siteLocation']);
        Route::post('/attendance/checkin/{token}', [AttendanceController::class, 'checkin']);
        Route::post('/attendance/checkout/{token}', [AttendanceController::class, 'checkout']);
        Route::get('/attendance/shift-schedule/{userID}', [AttendanceController::class, 'shiftSchedule']);

        // Package
        Route::post('/package', [PackageController::class, 'store']);
        Route::get('/packages', [PackageController::class, 'index']);
        Route::get('/package/unit/{id}', [PackageController::class, 'packageByUnit']);
        Route::get('/package/{id}', [PackageController::class, 'showPackage']);
        Route::post('/pickup/package/{id}/{token}', [PackageController::class, 'pickupPackage']);


        // Visitor
        Route::post('/visitor', [VisitorController::class, 'store']);
        Route::get('/visitors/unit/{id}', [VisitorController::class, 'visitorByUnit']);
        Route::get('/visitor/{id}', [VisitorController::class, 'show']);
        Route::post('/visitor/arrive/{id}', [VisitorController::class, 'arrive']);

        // Room
        Route::get('/rooms', [RoomController::class, 'index']);

        // Incedental Report
        Route::post('/incidental-report', [IncidentalController::class, 'store']);
        Route::get('/incidental-reports', [IncidentalController::class, 'index']);
        Route::get('/incidental-report/{id}', [IncidentalController::class, 'show']);

        // Tools
        Route::get('/tools/{wrID}', [ToolsController::class, 'index']);
        Route::post('/borrow-tool/{wrID}/{id}', [ToolsController::class, 'borrowTool']);
    });
});
