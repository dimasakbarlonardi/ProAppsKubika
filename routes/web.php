<?php

use App\Http\Controllers\Admin\FloorController;
use App\Http\Controllers\Admin\AgamaController;
use App\Http\Controllers\Admin\DepartemenController;
use App\Http\Controllers\Admin\DivisiController;
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
use App\Http\Controllers\Admin\JenisKelaminController;
use App\Http\Controllers\Admin\JenisKendaraanController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\KendaraanTenantController;
use App\Http\Controllers\Admin\KepemilikanUnitController;
use App\Http\Controllers\Admin\MemberTenantController;
use App\Http\Controllers\Admin\OwnerHController;
use App\Http\Controllers\Admin\PenempatanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PeriodeSewaController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Models\JenisKendaraan;
use App\Http\Controllers\Admin\StatusTinggalController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/testing-units', function () {
    return view('units');
})->name('dashboard');

// Check role id
Route::get('/check-role-id', [RoleController::class, 'checkRoleID']);
Route::post('/update-role-id', [RoleController::class, 'updateRoleID']);

Route::prefix('admin')->group(function () {
    Route::middleware(['auth'])->group(function () {

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

        // CRUD Tenant
        Route::resource('tenants', TenantController::class);

        // CRUD TenantUnit
        Route::resource('tenantunits', TenantUnitController::class);
        Route::get('tenant-unit/{id}', [TenantUnitController::class, 'getTenantUnit'])->name('getTenantUnit');

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

        // CRUD MemberTenant
        Route::resource('membertenants', MemberTenantController::class);

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


        // Akses form for user
        Route::get('/akses-form-user/{id}', [RoleController::class, 'aksesForm'])->name('akses-form');
        Route::post('/akses-form-user/{id}', [RoleController::class, 'storeAksesForm'])->name('akses-form');

        Route::get('/get-nav/{id}', [RoleController::class, 'getNavByRole'])->name('getNav');
    });
});

require __DIR__ . '/auth.php';
