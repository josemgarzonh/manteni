<?php

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\MaintenanceReportController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaintenanceScheduleController;
use App\Http\Controllers\DisposalProtocolController;
use App\Http\Controllers\HospitalRoundController;
use App\Http\Controllers\DefibrillatorTestController;
use App\Http\Controllers\BiomedicalDetailController;
use App\Http\Controllers\IpsController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\AssetTypeController;
use App\Http\Controllers\SparePartRequestController;
use App\Http\Controllers\TaskTeamController;
use App\Http\Controllers\FailureController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/mis-tareas', [DashboardController::class, 'myTasks'])->name('dashboard.my-tasks');

    Route::resource('users', UserController::class);
    Route::resource('assets', AssetController::class);
    Route::resource('maintenance-reports', MaintenanceReportController::class)->except(['show']);
    Route::get('/maintenance-reports/{report}', [MaintenanceReportController::class, 'show'])->name('maintenance-reports.show');
    Route::get('/maintenance-reports/{report}/pdf', [MaintenanceReportController::class, 'downloadPDF'])->name('maintenance-reports.pdf');

    Route::resource('schedules', MaintenanceScheduleController::class)->middleware('can:manage_schedules');
    Route::resource('ips', IpsController::class);
    Route::resource('sedes', SedeController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('hospital-rounds', HospitalRoundController::class);
    Route::resource('defibrillator-tests', DefibrillatorTestController::class);
    Route::resource('spare-part-requests', SparePartRequestController::class);
    Route::resource('task-teams', TaskTeamController::class);
    
    Route::get('/maintenance-requests/create', [MaintenanceRequestController::class, 'create'])->name('maintenance-requests.create');
    Route::post('/maintenance-requests', [MaintenanceRequestController::class, 'store'])->name('maintenance-requests.store');

    Route::get('/maintenance-requests', [MaintenanceRequestController::class, 'index'])->name('maintenance-requests.index');
    Route::get('/maintenance-requests/{request}', [MaintenanceRequestController::class, 'show'])->name('maintenance-requests.show');
    Route::post('/maintenance-requests/{request}/assign', [MaintenanceRequestController::class, 'assign'])->name('maintenance-requests.assign');

    Route::get('/assets/{asset}/hoja-de-vida', [AssetController::class, 'showHojaDeVida'])->name('assets.hoja-de-vida.show');
    Route::get('/assets/{asset}/hoja-de-vida/edit', [AssetController::class, 'editHojaDeVida'])->name('assets.hoja-de-vida.edit');
    Route::put('/assets/{asset}/hoja-de-vida', [AssetController::class, 'updateHojaDeVida'])->name('assets.hoja-de-vida.update');
    Route::get('/assets/{asset}/hoja-de-vida/pdf', [AssetController::class, 'downloadHojaDeVidaPDF'])->name('assets.hoja-de-vida.pdf');

    Route::get('/assets/{asset}/bitacora', [AssetController::class, 'showBitacora'])->name('assets.bitacora');
    Route::post('/assets/{asset}/bitacora', [AssetController::class, 'storeBitacoraEntry'])->name('assets.bitacora.store');
    Route::get('/assets/{asset}/bitacora/pdf', [AssetController::class, 'downloadBitacoraPDF'])->name('assets.bitacora.pdf');

    Route::get('/assets/{asset}/disposal/create', [DisposalProtocolController::class, 'create'])->name('disposal-protocols.create');
    Route::post('/assets/{asset}/disposal', [DisposalProtocolController::class, 'store'])->name('disposal-protocols.store');
    Route::get('/disposal-protocols/{protocol}', [DisposalProtocolController::class, 'show'])->name('disposal-protocols.show');

    Route::get('/assets/{asset}/biomedical-details/create', [BiomedicalDetailController::class, 'create'])->name('biomedical-details.create');
    Route::post('/assets/{asset}/biomedical-details', [BiomedicalDetailController::class, 'store'])->name('biomedical-details.store');
    
    Route::resource('servicios', ServicioController::class);
    Route::resource('zonas', ZonaController::class);
    Route::resource('asset-types', AssetTypeController::class);
    
    Route::get('/failures', [FailureController::class, 'index'])->name('failures.index');
    Route::get('/failures/{maintenanceRequest}/attend', [FailureController::class, 'attend'])->name('failures.attend');
    Route::post('/failures/{maintenanceRequest}/attend', [FailureController::class, 'storeAttention'])->name('failures.storeAttention');
    
    // Cronogramas
    Route::get('/schedules/calendar', [ScheduleController::class, 'calendar'])->name('schedules.calendar');
    Route::post('/schedules/{schedule}/status', [ScheduleController::class, 'updateStatus'])->name('schedules.status.update');
    Route::resource('schedules', ScheduleController::class);
    
    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    
    
    
});

// =======================================================================
// API Routes for Dynamic Dropdowns
// =======================================================================
Route::middleware('auth')->group(function () {
    Route::get('/api/sedes/{sede}/servicios', [App\Http\Controllers\SedeController::class, 'getServiciosForSede'])->name('api.sedes.servicios');
    Route::get('/api/sedes/{sede}/zonas', [App\Http\Controllers\SedeController::class, 'getZonasForSede'])->name('api.sedes.zonas');
    Route::get('/api/servicios/{servicio}/assets', [App\Http\Controllers\ServicioController::class, 'getAssetsForServicio'])->name('api.servicios.assets');
    Route::get('/api/assets/search', [App\Http\Controllers\AssetController::class, 'searchAssets'])->name('api.assets.search');
    Route::get('/api/assets/{asset}', [App\Http\Controllers\AssetController::class, 'getAssetDetails'])->name('api.assets.details');
});
    
require __DIR__.'/auth.php';