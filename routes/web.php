<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StateViewController;
use App\Http\Controllers\UploadExcelController;
use App\Http\Controllers\userDataController;
use App\Http\Controllers\StateViewController;
use App\Http\Controllers\UserFileUpload;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

//// My routes start here ////


// Route::middleware([CheckBlockAuth])->group(function () {
Route::group(['middleware' => ['CheckBlockAuth']], function () {

    Route::get('/upload-photo', [userDataController::class, 'showUserData'])->middleware(['auth', 'verified'])->name('uploadPhoto');
    Route::get('user_data', [userDataController::class, 'showUserData'])->middleware(['auth', 'verified'])->name('getdatabygp');
    Route::post('user_data', [userDataController::class, 'filterUserdata'])->middleware(['auth', 'verified']);
    Route::post('user_data_one', [userDataController::class, 'findUserdataOne'])->middleware(['auth', 'verified'])->name('findUserdataOne');
    Route::get('user_file_upload/{user_id}', [UserFileUpload::class, 'ShowFileUpload'])->middleware(['auth', 'verified']);
    Route::post('user_file_upload/{user_id}', [UserFileUpload::class, 'FileUpload'])->middleware(['auth', 'verified']);
    Route::get('view_data', [userDataController::class, 'viewdata'])->name('viewData')->middleware(['auth', 'verified']);
    Route::post('view_filtered_data', [userDataController::class, 'viewfilterUserdata'])->name('viewfiltereddata')->middleware(['auth', 'verified']);

    // ------------------------- upload excel data by gp ---------------------
    Route::get('/upload-excel', [UploadExcelController::class, 'index']);
    Route::post('/upload-excel-post', [UploadExcelController::class, 'uploadExcel']);
    // });
});

Route::post('user_data_oneview', [userDataController::class, 'findUserdataOneview'])->name('findUserdataOneview')->middleware(['auth', 'verified']);


// Route::middleware([checkdistrict::class])->group(function () {
Route::get('/viewDatadistrict', [UserDataController::class, 'showUserDatadistrict'])->name('viewDatadistrict');
Route::post('/view_filtered_data_by_block', [userDataController::class, 'viewfilterUserdatabyBlock'])->name('viewfiltereddatabyblock')->middleware(['auth', 'verified']);
Route::get('/state_show_all_data', [StateViewController::class, 'showAllData'])->name('showAllData');//(DK)
// });


// ------------------------ state view routes ---------------------
// --------------- get all uploaded data ---------------------
Route::post('/get-state-view', [StateViewController::class, 'viewAllUploadData']);
