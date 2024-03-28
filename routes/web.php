<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesAttachmentController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesPaymentsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Models\InvoicesAttachment;
use App\Models\InvoicesPayments;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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


Route::get('section/{id}',[SectionController::class,'getProducts']);
Route::get('/download/{file_folder}/{filename}', [InvoicesAttachmentController::class, 'download'])->name('file.download');



require __DIR__.'/auth.php';
