<?php

use App\Http\Controllers\Admin\FloorController;
use App\Http\Controllers\Admin\AgamaController;
use App\Http\Controllers\Admin\BAPPController;
use App\Http\Controllers\Admin\BayarnonController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartemenController;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\EngBAPPcontroller;
use App\Http\Controllers\Admin\GIGOController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\HKFloorController;
use App\Http\Controllers\Admin\HKKoridorController;
use App\Http\Controllers\Admin\HKTanggaDaruratController;
use App\Http\Controllers\Admin\InboxCntroller;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuHeadingController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PengurusController;
use App\Http\Controllers\Admin\SubMenu2Controller;
use App\Http\Controllers\Admin\SubMenuController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\TenantUnitController;
use App\Http\Controllers\Admin\TowerController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\HunianController;
use App\Http\Controllers\Admin\IdcardController;
use App\Http\Controllers\Admin\IPLTypeController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\JenisAcaraController;
use App\Http\Controllers\Admin\JenisDendaController;
use App\Http\Controllers\Admin\JenisKelaminController;
use App\Http\Controllers\Admin\JenisKendaraanController;
use App\Http\Controllers\Admin\JenisPekerjaanController;
use App\Http\Controllers\Admin\JenisRequestController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\KendaraanTenantController;
use App\Http\Controllers\Admin\KepemilikanUnitController;
use App\Http\Controllers\Admin\LiftController;
use App\Http\Controllers\Admin\MainFormController;
use App\Http\Controllers\Admin\MemberTenantController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OffBoardingKepemilikanUnitController;
use App\Http\Controllers\Admin\OffBoardingOwnerController;
use App\Http\Controllers\Admin\OffBoardingTenantController;
use App\Http\Controllers\Admin\OffBoardingTenantUnitController;
use App\Http\Controllers\Admin\OfficeManagementController;
use App\Http\Controllers\Admin\OpenTicket;
use App\Http\Controllers\Admin\OpenTicketController;
use App\Http\Controllers\Admin\OwnerHController;
use App\Http\Controllers\Admin\PenempatanController;
use App\Http\Controllers\Admin\PerhitDendaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PeriodeSewaController;
use App\Http\Controllers\Admin\RequestPermitController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\PerubahanUnitController;
use App\Http\Controllers\Admin\ReminderLetterController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\RuangReservationController;
use App\Http\Controllers\Admin\StatusAktifKaryawanController;
use App\Http\Controllers\Admin\StatusKaryawanController;
use App\Http\Controllers\Admin\StatusKawinController;
use App\Http\Controllers\Admin\StatusRequestController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\StatusTinggalController;
use App\Http\Controllers\Admin\ToiletController;
use App\Http\Controllers\Admin\TypeReservationController;
use App\Http\Controllers\Admin\UtilityController;
use App\Http\Controllers\Admin\WorkOrderController;
use App\Http\Controllers\Admin\WorkPermitController;
use App\Http\Controllers\Admin\WorkPriorityController;
use App\Http\Controllers\Admin\WorkRelationController;
use App\Http\Controllers\Admin\WorkRequestController;
use App\Http\Controllers\PaymentController;
use App\Models\ChecklistGensetH;
use App\Models\ChecklistGroundRoofH;
use App\Models\ChecklistListrikH;
use App\Models\ChecklistOfficeManagementH;
use App\Models\ChecklistPemadamH;
use App\Models\ChecklistPutrH;
use App\Models\MonthlyArTenant;

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
    return view('welcome');
});

Route::post('/payments/midtrans-notifications', [PaymentController::class, 'receive']);
Route::get('/delete/midtrans', [PaymentController::class, 'delete']);
Route::get('/check/midtrans', [PaymentController::class, 'check']);

// Check role id
Route::get('/check-role-id', [RoleController::class, 'checkRoleID']);

Route::prefix('admin')->group(function () {
    Route::middleware(['auth'])->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

        // CRUD TenantUnit
        Route::resource('tenantunits', TenantUnitController::class);
        Route::get('tenant-unit/{id}', [TenantUnitController::class, 'getTenantUnit'])->name('getTenantUnit');
        Route::get('get-vehicle/by-unit/{id}', [TenantUnitController::class, 'getVehicleUnit']);
        Route::get('get-vehicle/by-unit/{id}', [TenantUnitController::class, 'getVehicleUnit']);

        Route::get('/tenantunits/{id}', [TenantUnitController::class, 'show'])->name('tenantunitsShow');
        Route::post('/store/tenantunits', [TenantUnitController::class, 'storeTenantUnit'])->name('storeTenantUnit');
        Route::post('/update/tenantunits/{id}', [TenantUnitController::class, 'updateTenantUnit'])->name('updateTenantUnit');
        Route::post('/delete/tenantunit/{id}', [TenantUnitController::class, 'deleteTenantUnit'])->name('deleteTenantUnit');

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

        //CRUD OffBoarding Tenant Unit
        Route::resource('offtenantunits', OffBoardingTenantUnitController::class);

        //CRUD OffBoarding Kepemilikan Unit
        Route::resource('offkepemilkanunits', OffBoardingKepemilikanUnitController::class);

        Route::get('/get-jatuh-tempo', [OffBoardingTenantUnitController::class, 'jatuhtempo']);

        Route::get('/get-nav/{id}', [RoleController::class, 'getNavByRole'])->name('getNav');

        //CRUD OffBoarding Owner
        Route::resource('offowners', OffBoardingOwnerController::class);
        Route::get('ownerunit-by-id/{id}', [OffBoardingOwnerController::class, 'ownerByID'])->name('owner-by-id');
        Route::get('pic-by-id/{id}', [OffBoardingOwnerController::class, 'picByID'])->name('pic-by-id');

        //CRUD OffBoarding Tenant
        Route::resource('offtenants', OffBoardingTenantController::class);
        Route::get('tenant-unit-by-id/{id}', [OffBoardingTenantController::class, 'tenantByID'])->name('owner-by-id');
        Route::get('penjamin-by-id/{id}', [OffBoardingTenantController::class, 'penjaminByID'])->name('penjamin-by-id');
        Route::post('/update/tenantunits-offtenant/{id}', [OffBoardingTenantController::class, 'offdeleteTenantUnit'])->name('offdeleteTenantUnit');

        // CRUD Open Ticket
        Route::resource('/open-tickets', OpenTicketController::class);
        Route::post('/open-ticket/update-response/{id}', [OpenTicketController::class, 'updateRequestTicket'])->name('updateRequestTicket');
        Route::post('/open-ticket/approve1/{id}', [OpenTicketController::class, 'ticketApprove1'])->name('ticketApprove1');
        Route::post('/open-ticket/approve2/{id}', [OpenTicketController::class, 'ticketApprove2'])->name('ticketApprove2');

        // CRUD Work Request
        Route::resource('/work-requests', WorkRequestController::class);
        Route::post('/done/work-request/{id}', [WorkRequestController::class, 'done'])->name('doneWR'); // done wo from tenant
        Route::post('/complete/work-request/{id}', [WorkRequestController::class, 'complete'])->name('completeWR'); // done wo from tenant

        // CRUD Work Order
        Route::resource('/work-orders', WorkOrderController::class);
        Route::get('/work-order/no-wo', [WorkOrderController::class, 'showByNoWO']);
        Route::post('/accept/work-order/{id}', [WorkOrderController::class, 'acceptWO'])->name('acceptWO'); // accept wo from tenant
        Route::post('/approve2/work-order/{id}', [WorkOrderController::class, 'approve2WO'])->name('approve2WO'); // update wo from approve 2
        Route::post('/approve3/work-order/{id}', [WorkOrderController::class, 'approve3WO'])->name('approve3WO'); // update wo from approve 3
        Route::post('/work-done/work-order/{id}', [WorkOrderController::class, 'workDone'])->name('workDone'); // update wo from engineering
        Route::post('/done/work-order/{id}', [WorkOrderController::class, 'done'])->name('doneWO'); // done wo from tenant
        Route::post('/complete/work-order/{id}', [WorkOrderController::class, 'completeWO'])->name('completeWO'); // complete wo from finance

        // Request Permit
        Route::resource('/request-permits', RequestPermitController::class);
        Route::post('/request-permits/approve1/{id}', [RequestPermitController::class, 'approveRP1'])->name('approveRP1');

        // Work Permit
        Route::resource('/work-permits', WorkPermitController::class);
        Route::get('/open/request-permits', [WorkPermitController::class, 'openRP'])->name('openRP');
        Route::post('/work-permit/approve1/{id}', [WorkPermitController::class, 'approveWP1'])->name('approveWP1');
        Route::post('/work-permit/approve2/{id}', [WorkPermitController::class, 'approveWP2'])->name('approveWP2');
        Route::post('/work-permit/approve3/{id}', [WorkPermitController::class, 'approveWP3'])->name('approveWP3');
        Route::post('/work-permit/approve4/{id}', [WorkPermitController::class, 'approveWP4'])->name('approveWP4');
        Route::post('/work-permit/workDoneWP/{id}', [WorkPermitController::class, 'workDoneWP'])->name('workDoneWP');

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

        // Reservation
        Route::resource('request-reservations', ReservationController::class);
        Route::post('rsvApprove1/{id}', [ReservationController::class, 'approve1'])->name('rsvApprove1');
        Route::post('rsvApprove2/{id}', [ReservationController::class, 'approve2'])->name('rsvApprove2');
        Route::post('rsvApprove3/{id}', [ReservationController::class, 'approve3'])->name('rsvApprove3');
        Route::post('rsvDone/{id}', [ReservationController::class, 'rsvDone'])->name('rsvDone');
        Route::post('rsvComplete/{id}', [ReservationController::class, 'rsvComplete'])->name('rsvComplete');

        // Notification
        Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');  // Get all notifications list
        Route::get('/get-notifications', [DashboardController::class, 'getNotifications'])->name('getNotifications');  // Get all notifications by user_id
        Route::get('/notification/{id}', [DashboardController::class, 'showNotification'])->name('showNotification'); // Show all notification by user_id


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
        // Route::post('/update/kepemilikanunits-pindah/{id}', [PerubahanUnitController::class, 'updateKU'])->name('updateKU');
        Route::post('/update/tenantunits-pindahkepemilikan/{id}', [PerubahanUnitController::class, 'deleteKepemilikanUnit'])->name('deleteKepemilikanUnit');
        Route::post('/update/tenantunits-perpanjangan/{id}', [PerubahanUnitController::class, 'updateTenantUnit'])->name('updateTenantUnit2');
        Route::post('/update/kepemilikanunits-pindah/{id}', [PerubahanUnitController::class, 'updateKU'])->name('updateKU');
        Route::post('/update/tenantunits-perubahan/{id}', [PerubahanUnitController::class, 'updatePerubahanUnit'])->name('updatePerubahanUnit');
        // CRUD Work Order
        Route::resource('/work-orders', WorkOrderController::class);
        Route::get('/work-order/no-wo', [WorkOrderController::class, 'showByNoWO']);
        Route::post('/accept/work-order/{id}', [WorkOrderController::class, 'acceptWO'])->name('acceptWO'); // accept wo from tenant
        Route::post('/approve-2/work-order/{id}', [WorkOrderController::class, 'approve2'])->name('approve2'); // approve wo from engineering
        Route::post('/approve-3/work-order/{id}', [WorkOrderController::class, 'approve3'])->name('approve3'); // approve wo from engineering
        Route::post('/work-done/work-order/{id}', [WorkOrderController::class, 'workDone'])->name('workDone'); // update wo from engineering
        Route::post('/complete/work-order/{id}', [WorkOrderController::class, 'complete'])->name('completeWO'); // update wo to complete from finance
        Route::post('/approve-tr/work-order/{id}', [WorkOrderController::class, 'approveTR'])->name('approveTR'); // approve work done from engineering
        Route::post('/approve-spv/work-order/{id}', [WorkOrderController::class, 'approveSPV'])->name('approveSPV'); // approve work done from engineering SPV
        Route::post('/done/work-order/{id}', [WorkOrderController::class, 'done'])->name('doneWO'); // done wo from tenant
        Route::post('/complete/work-order/{id}', [WorkOrderController::class, 'completeWO'])->name('completeWO'); // complete wo from finance

        // Request Permit
        Route::resource('/request-permits', RequestPermitController::class);
        Route::post('/request-permits/approve1/{id}', [RequestPermitController::class, 'approveRP1'])->name('approveRP1');

        // Work Permit
        Route::resource('/work-permits', WorkPermitController::class);
        Route::get('/open/request-permits', [WorkPermitController::class, 'openRP'])->name('openRP');
        Route::post('/work-permit/approve1/{id}', [WorkPermitController::class, 'approveWP1'])->name('approveWP1');
        Route::post('/work-permit/approve2/{id}', [WorkPermitController::class, 'approveWP2'])->name('approveWP2');
        Route::post('/work-permit/approve3/{id}', [WorkPermitController::class, 'approveWP3'])->name('approveWP3');
        Route::post('/work-permit/approve4/{id}', [WorkPermitController::class, 'approveWP4'])->name('approveWP4');
        Route::post('/work-permit/workDoneWP/{id}', [WorkPermitController::class, 'workDoneWP'])->name('workDoneWP');

        // BAPP
        Route::resource('/bapp', BAPPController::class);
        Route::post('doneTF/{id}', [BAPPController::class, 'doneTF'])->name('doneTF');
        Route::post('bappApprove1/{id}', [BAPPController::class, 'bappApprove1'])->name('bappApprove1');
        Route::post('bappApprove2/{id}', [BAPPController::class, 'bappApprove2'])->name('bappApprove2');
        Route::post('bappApprove3/{id}', [BAPPController::class, 'bappApprove3'])->name('bappApprove3');
        Route::post('bappApprove4/{id}', [BAPPController::class, 'bappApprove4'])->name('bappApprove4');

        // Notification
        Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');  // Get all notifications list
        Route::get('/get-notifications', [DashboardController::class, 'getNotifications'])->name('getNotifications');  // Get all notifications by user_id
        Route::get('/notification/{id}', [DashboardController::class, 'showNotification'])->name('showNotification'); // Show all notification by user_id

    });
});

require __DIR__ . '/auth.php';
