<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public Pages
Route::get('/about', function () { 
    // Fetch the Chief / College Librarian for the About page bio
    // First try to find by title keyword, then fall back to the first staff record
    $chiefLibrarian = \App\Models\Staff::where('title', 'like', '%College Librarian%')
                                       ->orWhere('title', 'like', '%Chief Librarian%')
                                       ->orWhere('title', 'like', '%Librarian%')
                                       ->orderBy('id')
                                       ->first();
    // Final fallback: just grab the first staff record
    if (!$chiefLibrarian) {
        $chiefLibrarian = \App\Models\Staff::orderBy('id')->first();
    }
    return view('pages.about', compact('chiefLibrarian')); 
});
Route::get('/divisions', function () { return view('pages.divisions'); });
Route::get('/e-resources', function () {
    $resources = \App\Models\EResource::orderBy('category')->orderBy('order')->get();
    return view('pages.e-resources', compact('resources'));
});
Route::get('/gallery', function () {
    $images = \App\Models\GalleryImage::orderBy('order')->latest()->get();
    return view('pages.gallery', compact('images'));
});
Route::get('/staff', [App\Http\Controllers\StaffController::class, 'index']);

// Public Repository Routes
Route::prefix('repository')->name('repository.')->group(function () {
    Route::get('/', [App\Http\Controllers\RepositoryHomeController::class, 'index'])->name('home');
    Route::get('/search', [App\Http\Controllers\RepositorySearchController::class, 'index'])->name('search');
    Route::get('/item/{project}', [App\Http\Controllers\RepositoryProjectController::class, 'showPublic'])->name('projects.show_public');
    // View PDF inline - accessible to all, but controller checks auth for non-public items
    Route::get('/projects/{project}/view', [App\Http\Controllers\RepositoryProjectController::class, 'viewPdf'])->name('projects.view');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/activity-logs', [ActivityLogController::class, 'store'])->name('activity-logs.store');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Settings & Admin
    Route::get('/admin/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::post('/admin/settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
    
    // Staff Management (Admin)
    Route::middleware('role:admin')->prefix('admin/settings/staff')->name('settings.staff.')->group(function() {
        Route::get('/', [App\Http\Controllers\StaffController::class, 'adminIndex'])->name('index');
        Route::get('/create', [App\Http\Controllers\StaffController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\StaffController::class, 'store'])->name('store');
        Route::get('/{staff}/edit', [App\Http\Controllers\StaffController::class, 'edit'])->name('edit');
        Route::put('/{staff}', [App\Http\Controllers\StaffController::class, 'update'])->name('update');
        Route::delete('/{staff}', [App\Http\Controllers\StaffController::class, 'destroy'])->name('destroy');
    });

    // Gallery Management (Admin)
    Route::middleware('role:admin')->prefix('admin/settings/gallery')->name('settings.gallery.')->group(function() {
        Route::get('/', [App\Http\Controllers\GalleryImageController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\GalleryImageController::class, 'store'])->name('store');
        Route::put('/{gallery}', [App\Http\Controllers\GalleryImageController::class, 'update'])->name('update');
        Route::delete('/{gallery}', [App\Http\Controllers\GalleryImageController::class, 'destroy'])->name('destroy');
    });

    // E-Resources Management (Admin)
    Route::middleware('role:admin')->prefix('admin/settings/eresources')->name('settings.eresources.')->group(function() {
        Route::get('/', [App\Http\Controllers\EResourceController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\EResourceController::class, 'store'])->name('store');
        Route::get('/{eresource}/edit', [App\Http\Controllers\EResourceController::class, 'edit'])->name('edit');
        Route::put('/{eresource}', [App\Http\Controllers\EResourceController::class, 'update'])->name('update');
        Route::delete('/{eresource}', [App\Http\Controllers\EResourceController::class, 'destroy'])->name('destroy');
    });

    // Shared Routes
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    
    // Transactions & Borrowing (Students can only view their own via index)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/books/{book}/borrow', [TransactionController::class, 'borrow'])->name('books.borrow');
    Route::post('/transactions/{transaction}/return', [TransactionController::class, 'returnBook'])->name('transactions.return');

    // Librarian/Admin Only Routes
    Route::middleware('role:librarian')->group(function () {
        Route::resource('books', BookController::class)->except(['index']);
        Route::resource('students', StudentController::class);
        Route::resource('departments', App\Http\Controllers\DepartmentController::class);
        Route::get('/requests', [TransactionController::class, 'requests'])->name('transactions.requests');
        Route::post('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
        Route::post('/transactions/{transaction}/reject', [TransactionController::class, 'reject'])->name('transactions.reject');
        Route::post('/transactions/{transaction}/confirm-return', [TransactionController::class, 'confirmReturn'])->name('transactions.confirmReturn');
    });
    
    // Repository Routes (Authenticated / Admin only parts)
    Route::prefix('repository')->name('repository.')->group(function () {
        Route::middleware('role:librarian')->group(function () {
            Route::get('/dashboard', [App\Http\Controllers\RepositoryDashboardController::class, 'index'])->name('dashboard');
            Route::resource('projects', App\Http\Controllers\RepositoryProjectController::class);
            Route::get('/statistics', [App\Http\Controllers\RepositoryStatisticsController::class, 'index'])->name('statistics');
            
            // Download PDF (librarians only)
            Route::get('/projects/{project}/download', [App\Http\Controllers\RepositoryProjectController::class, 'downloadPdf'])->name('projects.download');
        });
    });

    // Admin Only
    Route::resource('librarians', LibrarianController::class)->middleware('role:admin');
});

require __DIR__.'/auth.php';
