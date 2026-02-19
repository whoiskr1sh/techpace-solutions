<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth', 'role:admin'])->get('/admin', function () {
    return 'Admin area';
})->name('admin.area');

require __DIR__ . '/auth.php';

use App\Http\Controllers\QuotationController;

Route::middleware(['auth'])->group(function () {
    Route::resource('quotations', QuotationController::class);
});

use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ProformaInvoiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\HsnCodeController;
use App\Http\Controllers\DuplicateQuotationController;

Route::middleware(['auth'])->group(function () {
    Route::resource('sales-orders', SalesOrderController::class);
    Route::post('vendors/import', [VendorController::class, 'import'])->name('vendors.import');
    Route::resource('vendors', VendorController::class);
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::resource('proforma-invoices', ProformaInvoiceController::class);
    Route::resource('invoices', InvoiceController::class)->middleware('check.invoice.visibility');
    Route::get('couriers', function () {
        return view('couriers.index');
    })->name('couriers.index');
    Route::resource('hsn-codes', HsnCodeController::class);
    Route::resource('duplicate-quotations', DuplicateQuotationController::class)->middleware('role:admin');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('activity-logs', ActivityLogController::class)->only(['index', 'show']);

        // Data Management
        Route::get('export-all', [\App\Http\Controllers\Admin\DataManagementController::class, 'exportAll'])->name('export-all')->middleware('role:admin,sales');
        Route::post('import-all', [\App\Http\Controllers\Admin\DataManagementController::class, 'importAll'])->name('import-all')->middleware('role:admin,sales');
    });
    Route::get('admin/settings', [SettingsController::class, 'edit'])->name('admin.settings.edit');
    Route::put('admin/settings', [SettingsController::class, 'update'])->name('admin.settings.update');
});

// (debug routes removed)
