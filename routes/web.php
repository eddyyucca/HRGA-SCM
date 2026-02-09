<?php

use Illuminate\Support\Facades\Route;
// Inventory
use App\Http\Controllers\Inventory\InventoryDashboardController;
use App\Http\Controllers\Inventory\InventoryItemController;
use App\Http\Controllers\Inventory\InventoryTransactionController;

// Mess dan Asset 
use App\Http\Controllers\Mess\DashboardController;
use App\Http\Controllers\Mess\OccupancyController;
use App\Http\Controllers\Mess\AssetController;
use App\Http\Controllers\Mess\RoomAvailabilityController;
use App\Http\Controllers\Mess\HotbedController;

/*
|--------------------------------------------------------------------------
| Web Routes - GA System
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/', fn() => redirect('/dashboard'));
Route::get('/dashboard', fn() => view('dashboard'));
Route::get('/laporan/transport', fn() => view('transport'));
Route::get('/laporan/inventory', fn() => view('inventory'));
Route::get('/laporan/kontrak', fn() => view('kontrak'));

// Travel Visitor
Route::get('/travel_visitor', fn() => view('travel_visitor.index'));
Route::get('/travel_visitor/create', fn() => view('travel_visitor.create'));
Route::get('/travel_visitor/edit', fn() => view('travel_visitor.edit'));
Route::get('/travel_visitor/report', fn() => view('travel_visitor.report'));


// ============================================================================
// TRANSPORT
// ============================================================================

// Kendaraan
Route::prefix('transport/kendaraan')->group(function () {
    Route::get('/', fn() => view('transport.kendaraan.index'));
    Route::get('/create', fn() => view('transport.kendaraan.create'));
    Route::get('/{id}', fn() => view('transport.kendaraan.show'));
    Route::get('/{id}/edit', fn() => view('transport.kendaraan.edit'));
    
    // Peminjaman
    Route::get('/peminjaman', fn() => view('transport.kendaraan.peminjaman.index'));
    Route::get('/peminjaman/create', fn() => view('transport.kendaraan.peminjaman.create'));
    Route::get('/peminjaman/{id}', fn() => view('transport.kendaraan.peminjaman.show'));
    
    // Maintenance
    Route::get('/maintenance', fn() => view('transport.kendaraan.maintenance.index'));
    Route::get('/maintenance/create', fn() => view('transport.kendaraan.maintenance.create'));
    Route::get('/maintenance/{id}', fn() => view('transport.kendaraan.maintenance.show'));
    
    // BBM
    Route::get('/bbm', fn() => view('transport.kendaraan.bbm.index'));
    Route::get('/bbm/create', fn() => view('transport.kendaraan.bbm.create'));
});

// Driver
Route::prefix('transport/driver')->group(function () {
    Route::get('/', fn() => view('transport.driver.index'));
    Route::get('/create', fn() => view('transport.driver.create'));
    Route::get('/{id}', fn() => view('transport.driver.show'));
    Route::get('/{id}/edit', fn() => view('transport.driver.edit'));
});

// ============================================================================
// TRAVEL MANAGEMENT
// ============================================================================


// Ticketing
Route::prefix('travel/ticketing')->group(function () {
    Route::get('/request', fn() => view('travel.ticketing.request.index'));
    Route::get('/request/create', fn() => view('travel.ticketing.request.create'));
    Route::get('/request/{id}', fn() => view('travel.ticketing.request.show'));
    
    Route::get('/booking', fn() => view('travel.ticketing.booking.index'));
    Route::get('/booking/create', fn() => view('travel.ticketing.booking.create'));
    Route::get('/booking/{id}', fn() => view('travel.ticketing.booking.show'));
    
    Route::get('/history', fn() => view('travel.ticketing.history.index'));
});

// Visitor
Route::prefix('travel/visitor')->group(function () {
    Route::get('/checkin', fn() => view('travel.visitor.checkin.index'));
    Route::get('/checkin/create', fn() => view('travel.visitor.checkin.create'));
    
    Route::get('/register', fn() => view('travel.visitor.register.index'));
    Route::get('/register/create', fn() => view('travel.visitor.register.create'));
    Route::get('/register/{id}', fn() => view('travel.visitor.register.show'));
    
    Route::get('/log', fn() => view('travel.visitor.log.index'));
});

// ============================================================================
// KONTRAK
// ============================================================================

// Route::prefix('kontrak')->group(function () {
//     Route::get('/', fn() => view('kontrak.index'));
//     Route::get('/create', fn() => view('kontrak.create'));
//     Route::get('/{id}', fn() => view('kontrak.show'));
//     Route::get('/{id}/edit', fn() => view('kontrak.edit'));
    
//     // Vendor
//     Route::get('/vendor', fn() => view('kontrak.vendor.index'));
//     Route::get('/vendor/create', fn() => view('kontrak.vendor.create'));
//     Route::get('/vendor/{id}', fn() => view('kontrak.vendor.show'));
//     Route::get('/vendor/{id}/edit', fn() => view('kontrak.vendor.edit'));
    
//     // Reminder
//     Route::get('/reminder', fn() => view('kontrak.reminder.index'));
// });

// ============================================================================
// INVENTORY
// ============================================================================
Route::prefix('inventory')->name('inventory.')->group(function () {
    
    // Dashboard
    Route::get('/', [InventoryDashboardController::class, 'index'])->name('dashboard');
    
    // Items
    Route::resource('items', InventoryItemController::class);
    
    // Transactions
    Route::resource('transactions', InventoryTransactionController::class)->only(['index', 'create', 'store', 'show']);
    
});

// ============================================================================
// ASET
// ============================================================================


Route::prefix('mess')->name('mess.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Occupancy / Hunian
    Route::get('/occupancy', [OccupancyController::class, 'index'])->name('occupancy.index');
    Route::get('/occupancy/room/{roomId}', [OccupancyController::class, 'byRoom'])->name('occupancy.room');

    // Assets
    Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');
    Route::get('/assets/location/{area}/{building?}/{room?}', [AssetController::class, 'byLocation'])->name('assets.location');

    // Room Availability
    Route::get('/rooms', [RoomAvailabilityController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/new-hire', [RoomAvailabilityController::class, 'forNewHire'])->name('rooms.newhire');
    Route::get('/rooms/visitor', [RoomAvailabilityController::class, 'forVisitor'])->name('rooms.visitor');

    // Hotbed
    Route::get('/hotbed', [HotbedController::class, 'index'])->name('hotbed.index');
    Route::get('/hotbed/available', [HotbedController::class, 'available'])->name('hotbed.available');
});



// ============================================================================
// LAPORAN
// ============================================================================

Route::prefix('laporan')->group(function () {
    Route::get('/transport', fn() => view('laporan.transport'));
    Route::get('/inventory', fn() => view('laporan.inventory'));
    Route::get('/kontrak', fn() => view('laporan.kontrak'));
});

// ============================================================================
// SETTINGS
// ============================================================================

Route::get('/settings', fn() => view('settings.index'));