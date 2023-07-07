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
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\JenisAcaraController;
use App\Http\Controllers\Admin\JenisKelaminController;
use App\Http\Controllers\Admin\JenisKendaraanController;
use App\Http\Controllers\Admin\JenisPekerjaanController;
use App\Http\Controllers\Admin\JenisRequestController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\KendaraanTenantController;
use App\Http\Controllers\Admin\KepemilikanUnitController;
use App\Http\Controllers\Admin\MemberTenantController;
use App\Http\Controllers\Admin\OpenTicket;
use App\Http\Controllers\Admin\OpenTicketController;
use App\Http\Controllers\Admin\OwnerHController;
use App\Http\Controllers\Admin\PenempatanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PeriodeSewaController;
use App\Http\Controllers\Admin\RequestPermitController;
use App\Http\Controllers\Admin\RuangReservationController;
use App\Http\Controllers\Admin\StatusAktifKaryawanController;
use App\Http\Controllers\Admin\StatusKaryawanController;
use App\Http\Controllers\Admin\StatusKawinController;
use App\Http\Controllers\Admin\StatusRequestController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\StatusTinggalController;
use App\Http\Controllers\Admin\TypeReservationController;
use App\Http\Controllers\Admin\WorkOrderController;
use App\Http\Controllers\Admin\WorkPermitController;
use App\Http\Controllers\Admin\WorkPriorityController;
use App\Http\Controllers\Admin\WorkRelationController;
use App\Http\Controllers\Admin\WorkRequestController;
use App\Http\Controllers\PaymentController;

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

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth'])->name('dashboard');

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

        Route::get('/get/tenantunits-edit/{id}', [TenantUnitController::class, 'editTenantUnit']);
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

        Route::get('/get-nav/{id}', [RoleController::class, 'getNavByRole'])->name('getNav');

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

        // Notification
        Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');  // Get all notifications list
        Route::get('/get-notifications', [DashboardController::class, 'getNotifications'])->name('getNotifications');  // Get all notifications by user_id
        Route::get('/notification/{id}', [DashboardController::class, 'showNotification'])->name('showNotification'); // Show all notification by user_id

    });
});

require __DIR__ . '/auth.php';
