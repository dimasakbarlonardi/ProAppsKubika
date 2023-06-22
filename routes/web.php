<?php

use App\Http\Controllers\Admin\FloorController;
use App\Http\Controllers\Admin\AgamaController;
use App\Http\Controllers\Admin\BayarnonController;
use App\Http\Controllers\Admin\ChecklistAhuDetailController;
use App\Http\Controllers\Admin\ChecklistAhuHController;
use App\Http\Controllers\Admin\ChecklistChillerHController;
use App\Http\Controllers\Admin\ChecklistGasHController;
use App\Http\Controllers\Admin\ChecklistGensetHController;
use App\Http\Controllers\Admin\ChecklistGroundRoofHController;
use App\Http\Controllers\Admin\ChecklistListrikHController;
use App\Http\Controllers\Admin\ChecklistPemadamHController;
use App\Http\Controllers\Admin\ChecklistPompaSumpitHController;
use App\Http\Controllers\Admin\ChecklistPutrHController;
use App\Http\Controllers\Admin\DepartemenController;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\EngAHUController;
use App\Http\Controllers\Admin\EngChillerController;
use App\Http\Controllers\Admin\EngDeepWheelController;
use App\Http\Controllers\Admin\EngGasController;
use App\Http\Controllers\Admin\EngGroundController;
use App\Http\Controllers\Admin\EngListrikController;
use App\Http\Controllers\Admin\EngPamController;
use App\Http\Controllers\Admin\EngPemadamController;
use App\Http\Controllers\Admin\EngPompasumpitController;
use App\Http\Controllers\Admin\EngPutrController;
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
use App\Http\Controllers\Admin\MemberTenantController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OfficeManagementController;
use App\Http\Controllers\Admin\OwnerHController;
use App\Http\Controllers\Admin\PenempatanController;
use App\Http\Controllers\Admin\PerhitDendaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PeriodeSewaController;
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
use App\Http\Controllers\Admin\WorkPriorityController;
use App\Http\Controllers\Admin\WorkRelationController;
use App\Models\ChecklistGensetH;
use App\Models\ChecklistGroundRoofH;
use App\Models\ChecklistListrikH;
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


Route::get('/testing-units', function () {
    return view('units');
})->name('dashboard');

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
        Route::post('/store/tenantunit', [TenantUnitController::class, 'storeTenantUnit'])->name('storeTenantUnit');
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
          
          // CRUD IPLType
          Route::resource('ipltypes', IPLTypeController::class);

          // CRUD Utility
          Route::resource('utilitys', UtilityController::class);

          // CRUD JenisDenda
          Route::resource('jenisdendas', JenisDendaController::class);
         
          //CRUD Perhit Denda
          Route::resource('perhitdendas', PerhitDendaController::class);

          //CRUD Reminder Letter
          Route::resource('reminders', ReminderLetterController::class);

          //CRUD Notification
          Route::resource('notifications', NotificationController::class);

          //CRUD Room
          Route::resource('rooms', RoomController::class);

          //CRUD Checklist AHU H
          Route::resource('checklistahus', ChecklistAhuHController::class);
          Route::get('/checklist-filter-ahu', [ChecklistAhuHController::class, 'filterByNoChecklist']);

          //CRUD Checklist AHU Detail
          Route::resource('ahudetails', ChecklistAhuDetailController::class);

          //CRUD Engeneering AHU 
          Route::resource('engahus', EngAHUController::class);

          //CRUD Engeneering Chiller 
          Route::resource('engchillers', EngChillerController::class);

          //CRUD Engeneering Listrik 
          Route::resource('englistriks', EngListrikController::class);
          
          //CRUD Engeneering PAM 
          Route::resource('engpams', EngPamController::class);

          //CRUD Engeneering DeepWheel 
          Route::resource('engdeeps', EngDeepWheelController::class);

          //CRUD Engeneering PompaSumpit 
          Route::resource('engpompas', EngPompasumpitController::class);

          //CRUD Engeneering GroundRoffTank 
          Route::resource('enggrounds', EngGroundController::class);

          //CRUD Engeneering Pemadam 
          Route::resource('engpemadams', EngPemadamController::class);

          //CRUD Engeneering Putr 
          Route::resource('engputrs', EngPutrController::class);

          //CRUD Engeneering Gas 
          Route::resource('enggases', EngGasController::class);

          //CRUD HK Toilet 
          Route::resource('toilets', ToiletController::class);

          //CRUD HK OfficeManagemet 
          Route::resource('officemanagements', OfficeManagementController::class);
          
          //CRUD HK Lift 
          Route::resource('lifts', LiftController::class);

          //CRUD HK Floor 
          Route::resource('hkfloors', HKFloorController::class);

          //CRUD HK Koridor 
          Route::resource('hkkoridors', HKKoridorController::class);

          //CRUD HK TanggaDarurat 
          Route::resource('hktanggadarurats', HKTanggaDaruratController::class);
          
          //CRUD Finn Monthly AR Tenant 
          Route::resource('monthlyartenants', MonthlyArTenant::class);

          //CRUD Checklist Chiller 
          Route::resource('checklistchillers', ChecklistChillerHController::class);
          Route::get('/checklist-filter-chiller ', [ChecklistChillerHController::class, 'filterByNoChecklist']);

          //CRUD Checklist Chiller 
          Route::resource('checklistchillers', ChecklistChillerHController::class);

          //CRUD Checklist Listrik 
          Route::resource('checklistlistriks', ChecklistListrikHController::class);
          Route::get('/checklist-filter-listrik', [ChecklistListrikHController::class, 'filterByNoChecklist']);

          //CRUD Checklist Pompa Sumpit 
          Route::resource('checklistpompasumpits', ChecklistPompaSumpitHController::class);
          Route::get('/checklist-filter-pompasumpit', [ChecklistPompaSumpitHController::class, 'filterByNoChecklist']);

          //CRUD Checklist GroundRoof 
          Route::resource('checklistgroundroofs', ChecklistGroundRoofHController::class);
          Route::get('/checklist-filter-groundroof', [ChecklistGroundRoofHController::class, 'filterByNoChecklist']);

          //CRUD Checklist Gas 
          Route::resource('checklistgases', ChecklistGasHController::class);
          Route::get('/checklist-filter-gas', [ChecklistGasHController::class, 'filterByNoChecklist']);

          //CRUD Checklist Genset 
          Route::resource('checklistgensets', ChecklistGensetHController::class);
          Route::get('/checklist-filter-genset', [ChecklistGensetHController::class, 'filterByNoChecklist']);

          //CRUD Checklist Pemadam 
          Route::resource('checklistpemadams', ChecklistPemadamHController::class);
          Route::get('/checklist-filter-pemadam', [ChecklistPemadamHController::class, 'filterByNoChecklist']);

          //CRUD Checklist PUTR 
          Route::resource('checklistputrs', ChecklistPutrHController::class);
          Route::get('/checklist-filter-putr', [ChecklistPutrHController::class, 'filterByNoChecklist']);
 
        // Akses form for user
        Route::get('/akses-form-user/{id}', [RoleController::class, 'aksesForm'])->name('akses-form');
        Route::post('/akses-form-user/{id}', [RoleController::class, 'storeAksesForm'])->name('akses-form');

        Route::get('/get-nav/{id}', [RoleController::class, 'getNavByRole'])->name('getNav');
    });
});

require __DIR__ . '/auth.php';
