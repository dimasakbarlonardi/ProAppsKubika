<?php


use App\Events\PaymentEvent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\BAPPController;
use App\Http\Controllers\Admin\GIGOController;
use App\Http\Controllers\Admin\InboxCntroller;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AgamaController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\FloorController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\TowerController;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\EngAHUController;
use App\Http\Controllers\Admin\HunianController;
use App\Http\Controllers\Admin\IdcardController;
use App\Http\Controllers\Admin\OwnerHController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\ToiletController;
use App\Http\Controllers\Admin\EngBAPPcontroller;
use App\Http\Controllers\Admin\HKFloorController;
use App\Http\Controllers\Admin\IPLTypeController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\SubMenuController;
use App\Http\Controllers\Admin\UtilityController;
use App\Http\Controllers\Admin\BayarnonController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\MainFormController;
use App\Http\Controllers\Admin\PengurusController;
use App\Http\Controllers\Admin\SubMenu2Controller;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HKKoridorController;
use App\Http\Controllers\Admin\WorkOrderController;
use App\Http\Controllers\Admin\DepartemenController;
use App\Http\Controllers\Admin\JenisAcaraController;
use App\Http\Controllers\Admin\JenisDendaController;
use App\Http\Controllers\Admin\OpenTicketController;
use App\Http\Controllers\Admin\PenempatanController;
use App\Http\Controllers\Admin\TenantUnitController;
use App\Http\Controllers\Admin\WorkPermitController;
use App\Http\Controllers\Admin\MenuHeadingController;
use App\Http\Controllers\Admin\PerhitDendaController;
use App\Http\Controllers\Admin\PeriodeSewaController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\StatusKawinController;
use App\Http\Controllers\Admin\WorkRequestController;
use App\Http\Controllers\Admin\JenisKelaminController;
use App\Http\Controllers\Admin\JenisRequestController;
use App\Http\Controllers\Admin\MemberTenantController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\WorkPriorityController;
use App\Http\Controllers\Admin\WorkRelationController;
use App\Http\Controllers\Admin\ChecklistAhuHController;
use App\Http\Controllers\Admin\PerubahanUnitController;
use App\Http\Controllers\Admin\RequestPermitController;
use App\Http\Controllers\Admin\StatusRequestController;
use App\Http\Controllers\Admin\StatusTinggalController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\ChecklistLiftHController;
use App\Http\Controllers\Admin\JenisKendaraanController;
use App\Http\Controllers\Admin\JenisPekerjaanController;
use App\Http\Controllers\Admin\ReminderLetterController;
use App\Http\Controllers\Admin\StatusKaryawanController;
use App\Http\Controllers\Admin\ChecklistFloorHController;
use App\Http\Controllers\Admin\ChecklistSolarHController;
use App\Http\Controllers\Admin\HKTanggaDaruratController;
use App\Http\Controllers\Admin\KendaraanTenantController;
use App\Http\Controllers\Admin\KepemilikanUnitController;
use App\Http\Controllers\Admin\TypeReservationController;
use App\Http\Controllers\Admin\ChecklistGensetHController;
use App\Http\Controllers\Admin\ChecklistToiletHController;
use App\Http\Controllers\Admin\OffBoardingOwnerController;
use App\Http\Controllers\Admin\OfficeManagementController;
use App\Http\Controllers\Admin\RuangReservationController;
use App\Http\Controllers\Admin\ChecklistKoridorHController;
use App\Http\Controllers\Admin\OffBoardingTenantController;
use App\Http\Controllers\Admin\ChecklistAhuDetailController;
use App\Http\Controllers\Admin\StatusAktifKaryawanController;
use App\Http\Controllers\Admin\ChecklistTemperaturHController;
use App\Http\Controllers\Admin\OffBoardingTenantUnitController;
use App\Http\Controllers\Admin\ChecklistTanggaDaruratHController;
use App\Http\Controllers\Admin\ChecklistOfficeManagementHController;
use App\Http\Controllers\Admin\ChecklistSecurityController;
use App\Http\Controllers\Admin\ChecklistToiletDetailController;
use App\Http\Controllers\Admin\CompanySettingController;
use App\Http\Controllers\Admin\ElectricUUSController;
use App\Http\Controllers\Admin\ForgotAttendanceController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\IncidentalEngController;
use App\Http\Controllers\Admin\IncidentalHKController;
use App\Http\Controllers\Admin\IncidentalReportController;
use App\Http\Controllers\Admin\InspectionSecurityController;
use App\Http\Controllers\Admin\LeaveTypeHRController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\OffBoardingKepemilikanUnitController;
use App\Http\Controllers\Admin\OffTenantUnitController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ParameterSecurityController;
use App\Http\Controllers\Admin\ParameterShiftSecurityController;
use App\Http\Controllers\Admin\PermitHRController;
use App\Http\Controllers\Admin\PPNController;
use App\Http\Controllers\Admin\ReminderController;
use App\Http\Controllers\Admin\RequestAttendanceController;
use App\Http\Controllers\Admin\RequestTypeController;
use App\Http\Controllers\Admin\ScheduleMeetingController;
use App\Http\Controllers\Admin\ScheduleSecurityController;
use App\Http\Controllers\Admin\ShiftTypeController;
use App\Http\Controllers\Admin\ToolsEngController;
use App\Http\Controllers\Admin\ToolsHKController;
use App\Http\Controllers\Admin\ToolsSecurityController;
use App\Http\Controllers\Admin\VisitorsController;
use App\Http\Controllers\Admin\WaterUUSController;
use App\Http\Controllers\API\VisitorController;
use App\Models\ForgotAttendance;
use App\Models\IncidentalReportHK;
use App\Models\PermitHR;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/gis', [AttendanceController::class, 'index']);
Route::post('/absence', [AttendanceController::class, 'absence']);

Route::get('payment-event', function () {
    $datanotif = [
        'id_site' => '004212',
        'id' => 122,
        'status' => 'settlement',
    ];
    broadcast(new PaymentEvent($datanotif));
});

Route::post('/payments/midtrans-notifications', [PaymentController::class, 'receive']);
Route::get('/delete/midtrans', [PaymentController::class, 'delete']);
Route::get('/check/midtrans', [PaymentController::class, 'check']);

// Surat izin kerja
Route::get('/work-permit/letter/{id}/{idSite}', [WorkPermitController::class, 'printWP']);

//dev
Route::get('/send-event', function () { });
Route::get('/notification', [AgamaController::class, 'notification']);
Route::post('/save-token', [AgamaController::class, 'saveToken'])->name('save-token');

// Check role id
Route::get('/check-role-id', [RoleController::class, 'checkRoleID']);

Route::get('/invoice/{id}', [PaymentController::class, 'invoice'])->name('invoice');
Route::get('/view-room/{idSite}/{id}', [RoomController::class, 'viewRoom']);

Route::prefix('admin')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/company-setting', [CompanySettingController::class, 'show'])->name('company-setting');
        Route::post('/company-setting', [CompanySettingController::class, 'update'])->name('update-company-setting');

        Route::get('/chats', [ChatController::class, 'index'])->name('chats');
        Route::get('/chats/rooms', [ChatController::class, 'rooms']);
        Route::get('/chats/rooms-slave', [ChatController::class, 'roomSlave']);
        Route::get('/chats/rooms-master', [ChatController::class, 'roomMaster']);
        Route::post('/chats', [ChatController::class, 'store']);
        Route::get('/get-chats', [ChatController::class, 'getChats']);
        Route::post('/read-chats', [ChatController::class, 'readChats']);

        Route::post('payment/check-payment-status/{id}', [PaymentController::class, 'checkStatus']);

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('announcements', AnnouncementController::class);
        Route::resource('reminders', ReminderController::class);

        // Tracking ticket
        Route::get('tracking-tickets', [MainFormController::class, 'index'])->name('trackingTickets');
        Route::get('tracking-ticket/{id}', [MainFormController::class, 'show'])->name('trackingTicketShow');

        // CRUD Groups
        Route::resource('groups', GroupController::class);

        // CRUD sites
        Route::resource('sites', SiteController::class);

        // CRUD Pengurus
        Route::resource('penguruses', PengurusController::class);

        // CRUD Login
        Route::resource('logins', LoginController::class);

        // CRUD User
        Route::resource('users', UserController::class);

        // CRUD Role
        Route::resource('roles', RoleController::class);

        //CURD Tower
        Route::resource('towers', TowerController::class);

        // CRUD Lantai
        Route::resource('floors', FloorController::class);

        // CRUD UNIT
        Route::resource('units', UnitController::class);
        Route::get('units-by-filter', [UnitController::class, 'unitsByFilter'])->name('unitsByFilter');

        // CRUD Tenant
        Route::resource('tenants', TenantController::class);
        Route::get('/filter-tenants/get-filter-data', [TenantController::class, 'filteredData']);

        // CRUD TenantUnit
        Route::resource('tenantunits', TenantUnitController::class);
        Route::get('tenant-unit/{id}', [TenantUnitController::class, 'getTenantUnit'])->name('getTenantUnit');
        Route::post('tenant-unit/unit', [TenantUnitController::class, 'getUnitIDFromTU'])->name('getUnitIDFromTU');
        Route::get('get-vehicle/by-unit/{id}', [TenantUnitController::class, 'getVehicleUnit']);
        Route::post('/store/tenantunit', [TenantUnitController::class, 'storeTenantUnit'])->name('storeTenantUnit');

        Route::get('/tenantunits/{id}', [TenantUnitController::class, 'show'])->name('tenantunitsShow');

        Route::get('/get/tenantmember-edit/{id}', [TenantUnitController::class, 'editTenantMember']);
        Route::post('/store/tenantmember', [TenantUnitController::class, 'storeTenantMember'])->name('storeTenantMember');
        Route::post('/update/tenantmember/{id}', [TenantUnitController::class, 'updateTenantMember'])->name('updateTenantMember');
        Route::post('/delete/tenantmember/{id}', [TenantUnitController::class, 'deleteTenantMember'])->name('deleteTenantMember');

        Route::post('/store/tenantvehicle', [TenantUnitController::class, 'storeTenantVehicle'])->name('storeTenantVehicle');
        Route::get('/get/tenantkendaraan-edit/{id}', [TenantUnitController::class, 'editTenantKendaraan']);
        Route::post('/update/tenantkendaraan/{id}', [TenantUnitController::class, 'updateTenantKendaraan'])->name('updateTenantKendaraan');
        Route::post('/delete/tenantkendaraan/{id}', [TenantUnitController::class, 'deleteTenantKendaraan'])->name('deleteTenantKendaraan');


        // CRUD menu
        Route::resource('menu-headings', MenuHeadingController::class);
        Route::get('/create-menu/{id}', [MenuController::class, 'createMenu'])->name('create-menu');
        Route::resource('menus', MenuController::class);
        Route::resource('sub-menus', SubMenuController::class);
        Route::get('/create-sub-menu/{id}', [SubMenuController::class, 'createSubMenu'])->name('create-sub-menu');
        Route::resource('sub-menus-2', SubMenu2Controller::class);
        Route::get('/create-sub-menu-2/{id}', [SubMenu2Controller::class, 'create'])->name('create-sub-menu-2');

        // CRUD Inbox
        Route::resource('inbox', InboxCntroller::class);

        // CRUD UNIT
        Route::resource('units', UnitController::class);
        Route::get('/units-by-tenant/{id}', [UnitController::class, 'UnitByTenant'])->name('UnitByTenant');

        // CRUD Tower
        Route::resource('towers', TowerController::class);

        // CRUD Lantai
        Route::resource('floors', FloorController::class);

        // CRUD Hunian
        Route::resource('hunians', HunianController::class);

        // CRUD Tenant
        Route::resource('tenants', TenantController::class);

        // CRUD TenantUnit
        Route::resource('tenantunits', TenantUnitController::class);

        // System Setting
        Route::resource('system-settings', SystemSettingController::class);
        Route::get('/system/approve', [SystemSettingController::class, 'systemApprove'])->name('systemApprove'); // Approve system
        Route::get('/system/approve/{id}', [SystemSettingController::class, 'editSystemApprove'])->name('editSystemApprove'); // edit Approve system
        Route::post('/system/approve/{id}', [SystemSettingController::class, 'updateSystemApprove'])->name('updateSystemApprove'); // update approve system

        // CRUD MemberTenant
        Route::resource('membertenants', MemberTenantController::class);
        Route::get('kepemilikan-member-unit/{id}', [MemberTenantController::class, 'kepemilikanUnitTenant'])->name('kepemilikan-unit-tenant');

        // CRUD KendaraanTenant
        Route::resource('kendaraans', KendaraanTenantController::class);

        // CRUD JenisKendaraan
        Route::resource('jeniskendaraans', JenisKendaraanController::class);

        // CRUD PeriodeSewa
        Route::resource('sewas', PeriodeSewaController::class);

        // CRUD ID Card
        Route::resource('idcards', IdcardController::class);

        // CRUD Owner
        Route::resource('owners', OwnerHController::class);

        // CRUD JenisKelamin
        Route::resource('genders', JenisKelaminController::class);

        // CRUD Agama
        Route::resource('agamas', AgamaController::class);

        // CRUD StatusTinggal
        Route::resource('statustinggals', StatusTinggalController::class);

        // CRUD StatusKawin
        Route::resource('statuskawins', StatusKawinController::class);

        // CRUD KepemilikanUnit
        Route::resource('kepemilikans', KepemilikanUnitController::class);
        Route::get('kepemilikan-unit/{id}', [KepemilikanUnitController::class, 'notKepemilikanUnit'])->name('create-kepemilikan-unit');
        Route::get('unit-by-id/{id}', [KepemilikanUnitController::class, 'unitByID'])->name('unit-by-id');
        Route::get('/unit-filter', [KepemilikanUnitController::class, 'unitdetail']);
        Route::post('kepemilikans', [KepemilikanUnitController::class, 'destroy'])->name('destroy');


        // CRUD Karyawan
        Route::resource('karyawans', KaryawanController::class);

        // CRUD Jabatan
        Route::resource('jabatans', JabatanController::class);

        // CRUD Divisi
        Route::resource('divisis', DivisiController::class);

        // CRUD Departemen
        Route::resource('departemens', DepartemenController::class);

        // CRUD Penempatan
        Route::resource('penempatans', PenempatanController::class);

        // CRUD Work Relation
        Route::resource('workrelations', WorkRelationController::class);

        // CRUD Status Request
        Route::resource('statusrequests', StatusRequestController::class);

        // CRUD Jenis Pekerjaan
        Route::resource('jenispekerjaans', JenisPekerjaanController::class);

        // CRUD Jenis Request
        Route::resource('jenisrequests', JenisRequestController::class);

        // CRUD Jenis Request
        Route::resource('jenisrequests', JenisRequestController::class);

        // CRUD Ruang Reservation
        Route::resource('ruangreservations', RuangReservationController::class);

        // CRUD Jenis Acara
        Route::resource('jenisacaras', JenisAcaraController::class);

        // CRUD Status Karyawan
        Route::resource('statuskaryawans', StatusKaryawanController::class);

        // CRUD Status Aktif Karyawan
        Route::resource('statusaktifkaryawans', StatusAktifKaryawanController::class);

        // CRUD Type Reservation
        Route::resource('typereservations', TypeReservationController::class);

        // CRUD Work Priority
        Route::resource('workprioritys', WorkPriorityController::class);

        // CRUD BayarNon
        Route::resource('bayarnons', BayarnonController::class);

        // Akses form for user
        Route::get('/akses-form-user/{id}', [RoleController::class, 'aksesForm'])->name('get-akses-form');
        Route::post('/akses-form-user/{id}', [RoleController::class, 'storeAksesForm'])->name('akses-form');
        Route::get('/access-mobile-menu/{id}', [RoleController::class, 'aksesMobile'])->name('akses-mobile');
        Route::post('/access-mobile-menu/{id}', [RoleController::class, 'storeAksesMobile'])->name('storeAksesMobile');

        //CRUD OffBoarding Tenant Unit
        Route::resource('offtenantunits', OffBoardingTenantUnitController::class);

        //CRUD OffBoarding Kepemilikan Unit
        Route::resource('offkepemilkanunits', OffBoardingKepemilikanUnitController::class);

        Route::get('/get-jatuh-tempo', [OffBoardingTenantUnitController::class, 'jatuhtempo']);

        Route::get('/get-nav/{id}', [RoleController::class, 'getNavByRole'])->name('getNav');

        // CRUD Open Ticket
        Route::resource('/open-tickets', OpenTicketController::class);
        Route::get('/request/get-filter-data', [OpenTicketController::class, 'filteredData']);
        Route::post('/open-ticket/update-response/{id}', [OpenTicketController::class, 'updateRequestTicket'])->name('updateRequestTicket');
        Route::post('/open-ticket/approve1/{id}', [OpenTicketController::class, 'ticketApprove1'])->name('ticketApprove1');
        Route::post('/open-ticket/approve2/{id}', [OpenTicketController::class, 'ticketApprove2'])->name('ticketApprove2');

        // CRUD Work Request
        Route::resource('/work-requests', WorkRequestController::class);
        Route::get('/work-request/get-filter-data', [WorkRequestController::class, 'filteredData']);
        Route::post('/done/work-request/{id}', [WorkRequestController::class, 'done'])->name('doneWR'); // done wo from tenant
        Route::post('/complete/work-request/{id}', [WorkRequestController::class, 'complete'])->name('completeWR'); // done wo from tenant

        // Request Permit
        Route::resource('/request-permits', RequestPermitController::class);
        Route::post('/request-permits/approve1/{id}', [RequestPermitController::class, 'approveRP1'])->name('approveRP1');
        Route::post('/request-permits/reject/{id}', [RequestPermitController::class, 'rejectRP'])->name('rejectRP');

        // Work Permit
        Route::resource('/work-permits', WorkPermitController::class);
        Route::get('/work-permit/get-filter-data', [WorkPermitController::class, 'filteredData']);
        Route::get('/open/request-permits', [WorkPermitController::class, 'openRP'])->name('openRP');
        Route::get('/work-permit/show/{id}', [BAPPController::class, 'showWP']);
        Route::post('/work-permit/reject/{id}', [WorkPermitController::class, 'rejectWP'])->name('rejectWP');
        Route::post('/work-permit/approve1/{id}', [WorkPermitController::class, 'approveWP1'])->name('approveWP1');
        Route::post('/work-permit/approve2/{id}', [WorkPermitController::class, 'approveWP2'])->name('approveWP2');
        Route::post('/work-permit/approve3/{id}', [WorkPermitController::class, 'approveWP3'])->name('approveWP3');
        Route::post('/work-permit/approve4/{id}', [WorkPermitController::class, 'approveWP4'])->name('approveWP4');
        Route::post('/work-permit/workDoneWP/{id}', [WorkPermitController::class, 'workDoneWP'])->name('workDoneWP');
        Route::post('/work-permit/doneWP/{id}', [WorkPermitController::class, 'doneWP'])->name('doneWP');
        Route::post('/work-permit/generate/{id}', [WorkPermitController::class, 'generatePaymentPO'])->name('generatePaymentPO');
        Route::get('/work-permit/payment/{id}', [WorkPermitController::class, 'paymentPO'])->name('paymentPO');
        Route::get('/work-permit/print-paper/{id}/{idSite}', [WorkPermitController::class, 'printWP'])->name('printWP');

        // Reservation
        Route::resource('request-reservations', ReservationController::class);
        Route::post('submit-reservations', [ReservationController::class, 'update'])->name('submit-reservation');
        Route::get('/open-ticket-rsv/{id}', [ReservationController::class, 'showRSVTicket']);
        Route::get('/request-rsv/get-filter-data', [ReservationController::class, 'filteredData']);
        Route::get('/reservation/get/booked-date', [ReservationController::class, 'getBookedDate']);
        Route::post('rsvReject/{id}', [ReservationController::class, 'reject'])->name('rsvReject');
        Route::post('rsvApprove1/{id}', [ReservationController::class, 'approve1'])->name('rsvApprove1');
        Route::post('rsvApprove2/{id}', [ReservationController::class, 'approve2'])->name('rsvApprove2');
        Route::post('rsvApprove3/{id}', [ReservationController::class, 'approve3'])->name('rsvApprove3');
        Route::post('rsvDone/{id}', [ReservationController::class, 'rsvDone'])->name('rsvDone');
        Route::post('rsvComplete/{id}', [ReservationController::class, 'rsvComplete'])->name('rsvComplete');
        Route::post('payment-rsv/{id}', [ReservationController::class, 'generatePaymentRSV'])->name('generatePaymentRSV');
        Route::get('payment-rsv/{rsv}/{id}', [ReservationController::class, 'paymentReservation'])->name('paymentReservation');

        // Notification
        Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');  // Get all notifications list
        Route::get('/get-notifications/{userID}', [DashboardController::class, 'getNotifications'])->name('getNotifications');  // Get all notifications by user_id
        Route::get('/get-new-notifications/{notifID}', [DashboardController::class, 'getNewNotifications'])->name('getNewNotifications');  // Get all notifications by user_id
        Route::get('/notification/{id}', [DashboardController::class, 'showNotification'])->name('showNotification'); // Show all notification by user_id

        // CRUD Work Order
        Route::resource('/work-orders', WorkOrderController::class);
        Route::get('/work-order/no-wo', [WorkOrderController::class, 'showByNoWO']);
        Route::post('/accept/work-order/{id}', [WorkOrderController::class, 'acceptWO'])->name('acceptWO'); // accept wo from tenant
        Route::post('/reject/work-order/{id}', [WorkOrderController::class, 'rejectWO'])->name('rejectWO'); // reject wo from tenant
        Route::post('/approve2/work-order/{id}', [WorkOrderController::class, 'approve2'])->name('approve2'); // approve wo from engineering
        Route::post('/approveBM/work-order/{id}', [WorkOrderController::class, 'approveBM'])->name('approveBM'); // approve wo from bm
        Route::post('/approve3/work-order/{id}', [WorkOrderController::class, 'approve3'])->name('approve3'); // approve wo from engineering
        Route::post('/work-done/work-order/{id}', [WorkOrderController::class, 'workDone'])->name('workDone'); // update wo from engineering
        Route::post('/complete/work-order/{id}', [WorkOrderController::class, 'complete'])->name('completeWO'); // update wo to complete from finance
        Route::post('/approve-tr/work-order/{id}', [WorkOrderController::class, 'approveTR'])->name('approveTR'); // approve work done from engineering
        Route::post('/approve-spv/work-order/{id}', [WorkOrderController::class, 'approveSPV'])->name('approveSPV'); // approve work done from engineering SPV
        Route::post('/done/work-order/{id}', [WorkOrderController::class, 'done'])->name('doneWO'); // done wo from tenant
        Route::post('/complete/work-order/{id}', [WorkOrderController::class, 'completeWO'])->name('completeWO'); // complete wo from finance

        // Request Permit
        Route::resource('/request-permits', RequestPermitController::class);
        Route::get('/open-ticket-rp/{id}', [RequestPermitController::class, 'showRPTicket']);
        Route::post('/request-permits/approve1/{id}', [RequestPermitController::class, 'approveRP1'])->name('approveRP1');

        // BAPP
        Route::resource('/bapp', BAPPController::class);
        Route::post('doneTF/{id}', [BAPPController::class, 'doneTF'])->name('doneTF');
        Route::post('bappApprove1/{id}', [BAPPController::class, 'bappApprove1'])->name('bappApprove1');
        Route::post('bappApprove2/{id}', [BAPPController::class, 'bappApprove2'])->name('bappApprove2');
        Route::post('bappApprove3/{id}', [BAPPController::class, 'bappApprove3'])->name('bappApprove3');
        Route::post('bappApprove4/{id}', [BAPPController::class, 'bappApprove4'])->name('bappApprove4');

        // GIGO
        Route::resource('gigo', GIGOController::class);
        Route::post('gigo/add-good', [GIGOController::class, 'addGood']);
        Route::post('gigo/remove-good', [GIGOController::class, 'removeGood']);
        Route::post('gigo/approve1/{id}', [GIGOController::class, 'gigoApprove1'])->name('gigoApprove1');
        Route::post('gigo/approve2/{id}', [GIGOController::class, 'gigoApprove2'])->name('gigoApprove2');
        Route::post('gigo/done/{id}', [GIGOController::class, 'gigoDone'])->name('gigoDone');
        Route::post('gigo/complete/{id}', [GIGOController::class, 'gigoComplete'])->name('gigoComplete');

        // Eng BAPP
        Route::resource('eng-bapp', EngBAPPcontroller::class);


        //CRUD OffBoarding Perubahan Unit
        Route::resource('offtenants', OffBoardingTenantController::class);
        Route::get('tenant-unit-by-id/{id}', [OffBoardingTenantController::class, 'tenantByID'])->name('tenant-by-id');
        Route::get('penjamin-by-id/{id}', [OffBoardingTenantController::class, 'penjaminByID'])->name('penjamin-by-id');
        Route::get('tenant-unit-by-tenant/{IDTenant}/{IDUnit}', [OffBoardingTenantController::class, 'TUByTenantID']);
        Route::post('/update/tenantunits-offtenant', [OffBoardingTenantController::class, 'offdeleteTenantUnit'])->name('offdeleteTenantUnit');

        // OffBoarding Tenant Unit
        Route::resource('off-tenant-unit', OffTenantUnitController::class);

        //CRUD OffBoarding Owner
        Route::resource('offowners', OffBoardingOwnerController::class);
        Route::get('ownerunit-by-id/{id}', [OffBoardingOwnerController::class, 'ownerByID'])->name('owner-by-id');
        Route::get('pic-by-id/{id}', [OffBoardingOwnerController::class, 'picByID'])->name('pic-by-id');

        // CRUD PerubahanUnit
        Route::resource('perubahanunits', PerubahanUnitController::class);
        Route::get('tenantunit-by-id/{id}', [PerubahanUnitController::class, 'unitBy'])->name('unit-by');
        Route::get('kepemilikanunit-by-id/{id}', [PerubahanUnitController::class, 'kepemilikanByID'])->name('kepemilikan-by-id');
        Route::get('perubahannunit-by-id/{id}', [PerubahanUnitController::class, 'perubahanByID'])->name('perubahan-by-id');

        Route::get('/get/perpanjangunits-edit/{id}', [PerubahanUnitController::class, 'edit'])->name('edittenantunit');
        Route::get('/get/kepemilikanunits-edit/{id}', [PerubahanUnitController::class, 'editKU'])->name('editkepemilikanunit');
        Route::get('/get/tidakperpanjangunits-edit/{id}', [PerubahanUnitController::class, 'editTPU'])->name('edittidakperpanjang');
        Route::get('/get/perubahanunits-edit/{id}', [PerubahanUnitController::class, 'editPerubahan'])->name('editperubahanunit');

        Route::get('/tenantunits-show/{id}', [PerubahanUnitController::class, 'show'])->name('tenant_units');
        Route::get('/kepemilikanunits-show/{id}', [PerubahanUnitController::class, 'showKU'])->name('kepemilikans');
        Route::get('/tidakperpanjangunit-show/{id}', [PerubahanUnitController::class, 'showTPU'])->name('tidakperpanjang');
        Route::get('/perubahantenantunits-show/{id}', [PerubahanUnitController::class, 'showPerubahan'])->name('perubahanunit');

        Route::post('/update/tenantunits-perpanjangan/{id}', [PerubahanUnitController::class, 'updateTenantUnit'])->name('updateTenantUnit');
        Route::post('/update/kepemilikanunits-pindah/{id}', [PerubahanUnitController::class, 'updateKU'])->name('updateKU');
        Route::post('/update/tenantunits-pindahkepemilikan/{id}', [PerubahanUnitController::class, 'deleteKepemilikanUnit'])->name('deleteKepemilikanUnit');
        Route::post('/update/tenantunits-perubahan/{id}', [PerubahanUnitController::class, 'updatePerubahanUnit'])->name('updatePerubahanUnit');
        Route::post('/update/tenantunits-tidakperpanjang/{id}', [PerubahanUnitController::class, 'deleteTenantUnit'])->name('deleteTenantUnit');

        Route::get('/validation/perubahan', [PerubahanUnitController::class, 'validationPerubahan'])->name('validationPerubahan');
        Route::get('/validation/perubahan/owner', [PerubahanUnitController::class, 'validationPerubahanOwner'])->name('validationPerubahanOwner');

        // ---------Eng Parameter--------

        //CRUD Room
        Route::resource('rooms', RoomController::class);

        //CRUD Parameter Engineering
        Route::resource('engahus', EngAHUController::class);

        // --------End Eng Parameter--------

        // -------HK Parameter-------

        //CRUD HK Toilet
        Route::resource('toilets', ToiletController::class);

        //CRUD HK Floor
        Route::resource('hkfloors', HKFloorController::class);

        //CRUD HK TanggaDarurat
        Route::resource('hktanggadarurats', HKTanggaDaruratController::class);

        // -------End HK Parameter-------

        // -------Fin Parameter--------

        // CRUD IPLType
        Route::resource('ipltypes', IPLTypeController::class);

        // CRUD Utility
        Route::resource('utilitys', UtilityController::class);

        // CRUD JenisDenda
        Route::resource('jenisdendas', JenisDendaController::class);
        Route::post('/jenis-denda/isactive/{id}', [JenisDendaController::class, 'isActive']);

        //CRUD Perhit Denda
        Route::resource('perhitdendas', PerhitDendaController::class);

        //CRUD Reminder Letter
        Route::resource('reminders-latter', ReminderLetterController::class);

        //CRUD PPN
        Route::resource('ppns', PPNController::class);

        // ----------End Fin Parameter---------

        // ----------Checklist AHU-------------

        //CRUD Checklist AHU H
        Route::resource('checklistahus', ChecklistAhuHController::class);
        Route::get('/checklist-filter-ahu', [ChecklistAhuHController::class, 'filterByNoChecklist']);
        Route::get('/inspection-engineering/{id}', [ChecklistAhuHController::class, 'front'])->name('front');
        Route::get('/inspection-enginerring', [ChecklistAhuHController::class, 'add'])->name('add');
        Route::get('/inspection-parameter-engineering/{id}', [ChecklistAhuHController::class, 'checklist'])->name('checklistengineering');
        Route::post('/checklist-parameter-engineering/{id}', [ChecklistAhuHController::class, 'checklistParameter'])->name('checklistParameter');
        Route::post('/inspection-enginerring', [ChecklistAhuHController::class, 'inspectionStore'])->name('inspectionStore');
        Route::get('/inspections/schedules/{id}', [ChecklistAhuHController::class, 'inspectionSchedules'])->name('inspectionSchedules');
        Route::post('/inspections/create-schedules/{id}', [ChecklistAhuHController::class, 'postSchedules'])->name('postSchedules');
        Route::post('/inspections/update-schedules/{id}', [ChecklistAhuHController::class, 'updateSchedules'])->name('updateSchedulesENG');
        Route::post('/inspections/destroy-schedules/{id}', [ChecklistAhuHController::class, 'destroySchedules'])->name('destroySchedules');

        //CRUD Checklist AHU Detail
        Route::resource('ahudetails', ChecklistAhuDetailController::class);

        //CRUD Checklist Solar
        Route::resource('checklistsolars', ChecklistSolarHController::class);
        Route::get('/checklist-filter-solar', [ChecklistSolarHController::class, 'filterByNoChecklist']);

        //CRUD Checklist Genset
        Route::resource('checklistgensets', ChecklistGensetHController::class);
        Route::get('/checklist-filter-genset', [ChecklistGensetHController::class, 'filterByNoChecklist']);

        //CRUD Checklist Temperatur
        Route::resource('checklisttemperaturs', ChecklistTemperaturHController::class);
        Route::get('/checklist-filter-temperatur', [ChecklistTemperaturHController::class, 'filterByNoChecklist']);

        // ------------End Checklist AHU---------------

        // ------------Checklist HK--------------------

        //CRUD Checklist Toilet
        Route::resource('checklisttoilets', ChecklistToiletHController::class);
        Route::get('/checklist-filter-toilet', [ChecklistToiletHController::class, 'filterByNoChecklist']);
        Route::get('/inspection-parameter-toilet/{id}', [ChecklistToiletHController::class, 'checklisttoilet'])->name('checklisttoilet');
        Route::post('/checklist-parameter-toilet/{id}', [ChecklistToiletHController::class, 'checklistParameterHK'])->name('checklistParameterHK');
        Route::get('/inspections-hk/schedules/{id}', [ChecklistToiletHController::class, 'inspectionSchedulesHK'])->name('inspectionSchedulesHK');
        Route::post('/inspections-hk/update-schedules/{id}', [ChecklistToiletHController::class, 'updateSchedulesHK'])->name('updateSchedulesHK');
        Route::post('/inspections-hk/schedules/{id}', [ChecklistToiletHController::class, 'postSchedulesHK'])->name('postSchedulesHK');
        Route::post('/inspections-hk/delete-schedules/{id}', [ChecklistToiletHController::class, 'deleteSchedulesHK'])->name('deleteSchedulesHK');

        //CRUD Checklist Toilet Detail
        Route::resource('toiletdetails', ChecklistToiletDetailController::class);

        //CRUD Checklist Floor
        Route::resource('checklistfloors', ChecklistFloorHController::class);
        Route::get('/checklist-filter-floor', [ChecklistFloorHController::class, 'filterByNoChecklist']);

        //CRUD Checklist Tangga Darurat
        Route::resource('checklisttanggadarurats', ChecklistTanggaDaruratHController::class);
        Route::get('/checklist-filter-tangga_darurat', [ChecklistTanggaDaruratHController::class, 'filterByNoChecklist']);

        // ---------------End Checklist HK-------------------

        // ---------------Start UUS Electric ----------------
        Route::get('uus-electric', [ElectricUUSController::class, 'index'])->name('usr-electric');
        Route::get('uus-electric-filtered', [ElectricUUSController::class, 'filteredData']);
        Route::get('/create/usr-electric', [ElectricUUSController::class, 'create'])->name('create-usr-electric');
        Route::post('approve/usr-electric', [ElectricUUSController::class, 'approve']);
        Route::post('update/usr-electric/{id}', [ElectricUUSController::class, 'update'])->name('updateElectric');
        Route::post('approve/update/usr-electric/{id}', [ElectricUUSController::class, 'approveUpdate'])->name('approveUpdateElectric');
        // ---------------End UUS Electric-----------------

        // ---------------Start UUS Water -------------------
        Route::get('uus-water', [WaterUUSController::class, 'index'])->name('uus-water');
        Route::get('uus-water-filtered', [WaterUUSController::class, 'filteredData']);
        Route::get('create/usr-water', [WaterUUSController::class, 'create'])->name('create-usr-water');
        Route::post('approve/usr-water', [WaterUUSController::class, 'approve'])->name('approve-usr-water');
        Route::post('update/usr-water/{id}', [WaterUUSController::class, 'update'])->name('updateWater');
        Route::post('approve/update/usr-water/{id}', [WaterUUSController::class, 'approveUpdate'])->name('approveUpdateWater');
        // ---------------End UUS Water -------------------

        // Generate monthly invoice IPL & Service charge
        Route::post('generate-invoice', [BillingController::class, 'generateMonthlyInvoice'])->name('generateMonthlyInvoice');

        // View invoice
        Route::get('view-invoice/{id}', [BillingController::class, 'viewInvoice'])->name('viewInvoice');

        // ===================Invoice===================
        // blast invoice
        Route::post('blast-invoice', [BillingController::class, 'blastMonthlyInvoice'])->name('blastMonthlyInvoice');
        // Invoice index
        Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices');
        Route::get('invoice/{id}', [InvoiceController::class, 'show'])->name('showInvoices');
        Route::get('/invoice/get/filter-data', [InvoiceController::class, 'filteredData']);

        // Payment monthly tenant
        Route::post('payment-monthly-page/{id}', [BillingController::class, 'generatePaymentMonthly'])->name('generatePaymentMonthly');
        Route::get('payment-monthly-page/{mt}/{id}', [BillingController::class, 'paymentMonthly'])->name('paymentMonthly');

        // Payment WO
        Route::post('payment-wo/{id}', [BillingController::class, 'generatePaymentWO'])->name('generatePaymentWO');
        Route::get('payment-wo/{woID}/{id}', [BillingController::class, 'paymentWO'])->name('paymentWO');


        Route::post('get-montly-ar', [BillingController::class, 'getOverdueARTenant']);

        Route::post('get/cc-token', [BillingController::class, 'getTokenCC']);

        // ---------------Inspection Gartur Security-----------------
        Route::resource('inspectionsecurity', InspectionSecurityController::class);

        // ---------------Import exl Inspection Security-----------------
        Route::post('import', [ImportController::class, 'import'])->name('import');

        // ---------------Inspection Tools Engineering-----------------
        Route::resource('toolsengineering', ToolsEngController::class);
        Route::get('/tools-eng/histories', [ToolsEngController::class, 'historyToolEng'])->name('historyToolEng');
        Route::post('/tools/borrow/{id}', [ToolsEngController::class, 'borrowTool'])->name('borrow.tool');
        Route::post('/tools/return/{id}', [ToolsEngController::class, 'returnTool'])->name('return.tool');

        // ---------------Inspection Tools Housekeeping-----------------
        Route::resource('toolshousekeeping', ToolsHKController::class);
        Route::get('/tools-hk/histories', [ToolsHKController::class, 'historyToolHK'])->name('historyToolHK');
        Route::post('/tools/borrowHK/{id}', [ToolsHKController::class, 'borrowToolHK'])->name('borrowHK.tool');
        Route::post('/tools/returnHK/{id}', [ToolsHKController::class, 'returnToolHK'])->name('returnHK.tool');

        // ---------------Inspection Tools Security-----------------
        Route::resource('tools-security', ToolsSecurityController::class);
        Route::get('/history-tools-security', [ToolsSecurityController::class, 'History'])->name('history');
        Route::post('tools/borrowSecurity/{id}', [ToolsSecurityController::class, 'borrowToolSecurity'])->name('borrowSecurity.tool');
        Route::post('tools/returnSecurity/{id}', [ToolsSecurityController::class, 'returnToolSecurity'])->name('returnSecurity.tool');

        // ---------------Inspection Security-----------------
        Route::resource('checklistsecurity', ChecklistSecurityController::class);
        // -Schedule Security
        Route::resource('schedulesecurity', ScheduleSecurityController::class);

        // ---------------Incidental Report Engineering-----------------
        Route::resource('incidentalreporteng', IncidentalEngController::class);

        // ---------------Incidental Report HK-----------------
        Route::resource('incidentalreporthk',  IncidentalHKController::class);

        // ---------------Incidental Reports----------------
        Route::resource('incidentalreport',  IncidentalReportController::class);

        // -------------------Attendance-----------------------
        // -Schedule Meeting
        Route::resource('schedulemeeting', ScheduleMeetingController::class);
        Route::get('/data-employee/{id}', [ScheduleMeetingController::class, 'dataEmployee'])->name('dataEmployee');
        Route::post('/data-employee-store', [ScheduleMeetingController::class, 'storedataEmployee'])->name('storedataEmployee');
        Route::get('/employee-meeting/{id}', [ScheduleMeetingController::class, 'employeeMeeting'])->name('employeeMeeting');

        // presences
        Route::get('/presences', [AttendanceController::class, 'index'])->name('presences');
        Route::get('/presences-by-month', [AttendanceController::class, 'presenceByMonth']);
        Route::get('/coordinates', [AttendanceController::class, 'coordinates'])->name('coordinates');

        // ---------------Parameter Attendance------------------
        // -Request Attendancence
        Route::resource('requesttype', RequestTypeController::class);
        // -Permit Type
        Route::resource('permithr', PermitHRController::class);
        // -Leave Type
        Route::resource('leavetype', LeaveTypeHRController::class);
        // -Forgot Type
        Route::resource('forgottype', ForgotAttendanceController::class);
        // -Shift Type
        Route::resource('shifttype', ShiftTypeController::class);

        // Work Schedule
        Route::get('/work-schedules', [ShiftTypeController::class, 'listWorkSchedules'])->name('listWorkSchedules');
        Route::get('/work-schedules/{id}', [ShiftTypeController::class, 'workSchedules'])->name('workSchedules');
        Route::post('/work-schedules/store/{id}', [ShiftTypeController::class, 'storeWorkSchedules'])->name('storeWorkSchedules');

        // --------------- Attendance ------------------
        Route::resource('requestattendance', RequestAttendanceController::class);
        Route::post('/permit-attendance/approve/{id}', [RequestAttendanceController::class, 'approvePermitAttendance'])->name('approvePermitAttendance');


        // ---------------Package------------------
        Route::resource('packages', PackageController::class);

        // ---------------Visitor------------------
        Route::resource('visitor', VisitorsController::class);

        // --------------Parameter Security---------
        Route::resource('Parameter-Security', ParameterSecurityController::class);

          // --------------Parameter Shift Security---------
          Route::resource('Parameter-Shift-Security', ParameterShiftSecurityController::class);
    });
});

require __DIR__ . '/auth.php';
