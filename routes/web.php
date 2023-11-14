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



    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /*Organization*/
    Route::resource('organizations', \App\Http\Controllers\OrganizationController::class);

    /*Event categories JSON*/
    Route::get('/event-categoryData', [\App\Http\Controllers\EventCategoryController::class, 'data'])
        ->name('event-category.data');
    /*Events*/
    Route::resource('event-category', \App\Http\Controllers\EventCategoryController::class);
    Route::resource('events', \App\Http\Controllers\EventController::class);
    Route::get('/browse-events', [\App\Http\Controllers\EventController::class, 'display'])
        ->name('events.frontend');
        //Voting
    Route::get('/event/{event}/vote', [\App\Http\Controllers\EventController::class, 'vote'])
        ->name('event.vote');
    //Online Voting
    Route::get('/event/{event}/voteOnline', [\App\Http\Controllers\EventController::class, 'voteOnline'])
        ->name('event.vote.online');


        //Create Election
    Route::get('/event/{event}/create-election', [\App\Http\Controllers\ElectionController::class, 'create'])->name('election.create');

  /*Voting CRUD*/
    Route::resource('vote', \App\Http\Controllers\VoteController::class);










    //Content upload


    /*Grape JS DB storage*/
    Route::get('/grapejs-landing-pageGet/{landing_page}', [\App\Http\Controllers\LandingPageController::class, 'pageGet'])->name('grapejs.get');
//    Route::post('/grapejs-landing-pageUpload/{landing_page}', [\App\Http\Controllers\LandingPageController::class, 'pageUpload'])->name('grapejs.store');
//    Route::patch('/grapejs-landing-pageUpdate/{landing_page}', [\App\Http\Controllers\LandingPageController::class, 'pageUpdate'])->name('grapejs.update');
    Route::match(['patch', 'post'], '/grapejs-landing-pageUpload/{landing_page}', [\App\Http\Controllers\LandingPageController::class, 'pageUpload'])->name('grapejs.store');



    //Upload TinyMCE images
    Route::post('/upload-images-tinyMCE', [\App\Http\Controllers\UploadImagesController::class, 'upload'])->name('uploadImages.tiny');




});

require __DIR__.'/auth.php';
