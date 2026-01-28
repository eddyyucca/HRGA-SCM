<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Inventory\asset_index_controller;
use App\Http\Controllers\Inventory\asset_report_controller;
use App\Http\Controllers\Inventory\asset_movement_controller;
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

// Barang
Route::prefix('inventory')->group(function () {
    Route::get('/barang', fn() => view('inventory.barang.index'));
    Route::get('/barang/create', fn() => view('inventory.barang.create'));
    Route::get('/barang/{id}', fn() => view('inventory.barang.show'));
    Route::get('/barang/{id}/edit', fn() => view('inventory.barang.edit'));
    
    // Kategori
    Route::get('/kategori', fn() => view('inventory.kategori.index'));
    Route::get('/kategori/create', fn() => view('inventory.kategori.create'));
    Route::get('/kategori/{id}/edit', fn() => view('inventory.kategori.edit'));
    
    // Barang Masuk
    Route::get('/masuk', fn() => view('inventory.masuk.index'));
    Route::get('/masuk/create', fn() => view('inventory.masuk.create'));
    Route::get('/masuk/{id}', fn() => view('inventory.masuk.show'));
    
    // Barang Keluar
    Route::get('/keluar', fn() => view('inventory.keluar.index'));
    Route::get('/keluar/create', fn() => view('inventory.keluar.create'));
    Route::get('/keluar/{id}', fn() => view('inventory.keluar.show'));
    
    // Stock Opname
    Route::get('/opname', fn() => view('inventory.opname.index'));
    Route::get('/opname/create', fn() => view('inventory.opname.create'));
    Route::get('/opname/{id}', fn() => view('inventory.opname.show'));
});

// ============================================================================
// ASET
// ============================================================================

Route::prefix('aset')->group(function () {
    Route::get('/', fn() => view('aset.index'));
    Route::get('/create', fn() => view('aset.create'));
    Route::get('/{id}', fn() => view('aset.show'));
    Route::get('/{id}/edit', fn() => view('aset.edit'));
    
    // Peminjaman Aset
    Route::get('/peminjaman', fn() => view('aset.peminjaman.index'));
    Route::get('/peminjaman/create', fn() => view('aset.peminjaman.create'));
    Route::get('/peminjaman/{id}', fn() => view('aset.peminjaman.show'));
    
    // Maintenance Aset
    Route::get('/maintenance', fn() => view('aset.maintenance.index'));
    Route::get('/maintenance/create', fn() => view('aset.maintenance.create'));
    Route::get('/maintenance/{id}', fn() => view('aset.maintenance.show'));
});


/*
|--------------------------------------------------------------------------
| Inventory Asset Routes
|--------------------------------------------------------------------------
*/

Route::prefix('inventory/asset')->name('inventory.asset.')->group(function () {
    
    // Index & Detail
    Route::get('/', [asset_index_controller::class, 'index'])->name('index');
    Route::get('/show/{id}', [asset_index_controller::class, 'show'])->name('show');
    
    // Reports
    Route::get('/report/same', [asset_report_controller::class, 'same_assets'])->name('same');
    Route::get('/report/summary', [asset_report_controller::class, 'summary_by_location'])->name('summary');
    Route::get('/location/{id}', [asset_report_controller::class, 'by_location'])->name('location');
    
    // Movement
    Route::get('/movement', [asset_movement_controller::class, 'index'])->name('movement.index');
    Route::get('/movement/history/{id}', [asset_movement_controller::class, 'history'])->name('movement.history');
    
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