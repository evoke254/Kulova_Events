<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\landingpageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|

Route::get('/dashboardjkkjjkjkjkjjkkjkjjkjkj', function () {
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboardghghghgghhghghghghghghg');

*/


Route::get('/', [landingpageController::class, 'index'])->name('landing');
Route::get('/home', [landingpageController::class, 'home'])->name('home');


Route::middleware('auth')->group(function () {

    //Preview Mail
    Route::get('/preview_mail/{emailTemplate}', [\App\Http\Controllers\MailGarage::class, 'render'])->name('mail.preview');


    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /*Campaigns*/
    Route::resource('campaigns', CampaignController::class);

    /*Email List*/
    Route::resource('mail_list', \App\Http\Controllers\MailListController::class);
    /*Email Template*/
    Route::resource('emailTemplate', \App\Http\Controllers\EmailTemplateController::class);
    /*Landing page route */
    Route::resource('landing-page', \App\Http\Controllers\LandingPageController::class);
    /*Grape JS DB storage*/
    Route::get('/grapejs-landing-pageGet/{landing_page}', [\App\Http\Controllers\LandingPageController::class, 'pageGet'])->name('grapejs.get');
//    Route::post('/grapejs-landing-pageUpload/{landing_page}', [\App\Http\Controllers\LandingPageController::class, 'pageUpload'])->name('grapejs.store');
//    Route::patch('/grapejs-landing-pageUpdate/{landing_page}', [\App\Http\Controllers\LandingPageController::class, 'pageUpdate'])->name('grapejs.update');
    Route::match(['patch', 'post'], '/grapejs-landing-pageUpload/{landing_page}', [\App\Http\Controllers\LandingPageController::class, 'pageUpload'])->name('grapejs.store');


    Route::resource('campaign-template', \App\Http\Controllers\CampaignTemplateController::class);

    //Upload TinyMCE images
    Route::post('/upload-images-tinyMCE', [\App\Http\Controllers\UploadImagesController::class, 'upload'])->name('uploadImages.tiny');




});
    Route::get('/grapejs-landing-pageGet/{landing_page}', [\App\Http\Controllers\LandingPageController::class, 'pageGet'])->name('grapejs.get');

require __DIR__.'/auth.php';
