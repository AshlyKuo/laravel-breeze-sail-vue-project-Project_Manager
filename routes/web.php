<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ImageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('projects');
    } else {
        return redirect()->route('login');
    }
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/projects', function(){
    return Inertia::render('SaleProjects');
})->middleware(['auth', 'verified'])->name('projects');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->get('/project/{houseId}/progress', function ($houseId) {
    return Inertia::render('Progress', [
        'houseId' => $houseId,
    ]);
});

Route::middleware(['auth', 'verified', 'access.quotation'])->get('/project/{houseId}/quotation', function ($houseId){
    return Inertia::render('Quotation', [
        'houseId' => $houseId
    ]);
});
Route::middleware(['auth', 'verified', 'access.contract'])->get('/project/{houseId}/contract', function ($houseId){
    return Inertia::render('Contract', [
        'houseId' => $houseId
    ]);
});
Route::middleware(['auth', 'verified', 'access.supply'])->get('/project/{houseId}/supply', function ($houseId){
    return Inertia::render('SupplyCheck', [
        'houseId' => $houseId
    ]);
});
Route::middleware(['auth', 'verified', 'access.supply'])->get('/project/{houseId}/supply_confirm', function ($houseId){
    return Inertia::render('SupplyConfirm', [
        'houseId' => $houseId
    ]);
});
Route::middleware(['auth', 'verified', 'access.installation'])->get('/project/{houseId}/installation', function ($houseId){
    return Inertia::render('Installation', [
        'houseId' => $houseId
    ]);
});
Route::middleware(['auth', 'verified', 'access.delivery'])->get('/project/{houseId}/delivery', function ($houseId){
    return Inertia::render('Delivery', [
        'houseId' => $houseId
    ]);
});
Route::middleware(['auth', 'verified', 'access.admin'])->get('/admin', function (){
    return Inertia::render('Admin');
})->name('admin');


Route::post('/uploadPicture', [ImageController::class, 'upload'])->name('image.upload');
Route::post('/deletePicture', [ImageController::class, 'delete'])->name('image.delete');

require __DIR__.'/auth.php';
