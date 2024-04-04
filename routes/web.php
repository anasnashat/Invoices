<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesAttachmentController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesPaymentsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Models\InvoicesAttachment;
use App\Models\InvoicesPayments;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return redirect()->route('dashboard');
});
Route::get('/dashboard', function () {
    return view('home.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



Route::get('admin/{page}',[AdminController::class,'index']);

Route::resource('invoices', InvoicesController::class);

Route::prefix('invoice/{invoices}/payment')->group(function () {
    Route::get('create', [InvoicesPaymentsController::class, 'create'])->name('payment.create');
    Route::post('/', [InvoicesPaymentsController::class, 'store'])->name('payment.store');
    Route::get('{invoices_payments}/edit', [InvoicesPaymentsController::class, 'edit'])->name('payment.edit');
    Route::put('{invoices_payments}', [InvoicesPaymentsController::class, 'update'])->name('payment.update');
    Route::delete('{invoices_payments}', [InvoicesPaymentsController::class, 'destroy'])->name('payment.destroy');
});

Route::resource('attachment', InvoicesAttachmentController::class);
Route::resource('sections', SectionController::class);
Route::resource('products', ProductController::class);
Route::resource('users', UserController::class);
Route::middleware(['permission:عرض صلاحية'])->group(function () {
    Route::get('roles', [RolesController::class, 'index'])->name('roles.index');
});
Route::get('roles/show/{id}', [RolesController::class, 'show'])->name('roles.show');

Route::middleware(['permission:اضافة صلاحية'])->group(function () {
    Route::get('roles/create', [RolesController::class, 'create'])->name('roles.create');
    Route::post('roles', [RolesController::class, 'store'])->name('roles.store');
});

Route::middleware(['permission:تعديل صلاحية'])->group(function () {
    Route::get('roles/{role}/edit', [RolesController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{role}', [RolesController::class, 'update'])->name('roles.update');
});

Route::middleware(['permission:حذف صلاحية'])->group(function () {
    Route::delete('roles/{role}', [RolesController::class, 'destroy'])->name('roles.destroy');
});


Route::get('section/{id}',[SectionController::class,'getProducts']);
Route::get('invoices/print/{invoices}',[InvoicesController::class,'printInvoice'])->name('invoices.print');
Route::get('/download/{file_folder}/{filename}', [InvoicesAttachmentController::class, 'download'])->name('file.download');

Route::get('invoices/payments/excel/{invoiceId}',[InvoicesPaymentsController::class,'export'])->name('payments.export');
Route::get('invoices/payments/excel',[InvoicesController::class,'export'])->name('invoices.export');


Route::prefix('reports/')->group(function (){
    Route::get('invoices',[ReportsController::class,'invoices'])->name('reports.invoices');
    Route::post('invoices',[ReportsController::class,'invoices_filter'])->name('reports.invoices_filter');
    Route::get('customers',[ReportsController::class,'customers'])->name('reports.customers');
    Route::post('customers',[ReportsController::class,'customers_filter'])->name('reports.customers_filter');
});

});

require __DIR__.'/auth.php';
