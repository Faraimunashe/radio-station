<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EmployeeController as AdminEmployeeController;
use App\Http\Controllers\Archivist\DashboardController as ArchivistDashboardController;
use App\Http\Controllers\Archivist\MusicController as ArchivistMusicController;
use App\Http\Controllers\Archivist\PlaylistController as ArchivistPlaylistController;
use App\Http\Controllers\Audience\AdvertController;
use App\Http\Controllers\Audience\DashboardController;
use App\Http\Controllers\AuthenticatorController;
use App\Http\Controllers\Ep\DashboardController as EpDashboardController;
use App\Http\Controllers\Ep\FinanceController;
use App\Http\Controllers\Ep\JingleController;
use App\Http\Controllers\Ep\ScheduleController as EpScheduleController;
use App\Http\Controllers\Ep\ScriptController as EpScriptController;
use App\Http\Controllers\Presenter\DashboardController as PresenterDashboardController;
use App\Http\Controllers\Presenter\PlaylistController as PresenterPlaylistController;
use App\Http\Controllers\Presenter\ScheduleController as PresenterScheduleController;
use App\Http\Controllers\Presenter\ScriptController as PresenterScriptController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', [AuthenticatorController::class, 'index'])->middleware('auth')->name('dashboard');

Route::group(['middleware' => ['auth', 'role:admin']], function(){
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin-dashboard');

    Route::resource('employees', AdminEmployeeController::class);
});

Route::group(['middleware' => ['auth', 'role:archivist']], function(){
    Route::get('/archivist/dashboard', [ArchivistDashboardController::class, 'index'])->name('archivist-dashboard');

    Route::resource('musics', ArchivistMusicController::class);
    Route::get('/archivist/playlists', [ArchivistPlaylistController::class,'index'])->name('archivist-playlists');
    Route::get('/archivist/playlist/{id}', [ArchivistPlaylistController::class,'show'])->name('archivist-show-playlist');
    Route::post('/archivist/playlists/{id}', [ArchivistPlaylistController::class,'update'])->name('archivist-playlist');
});

Route::group(['middleware' => ['auth', 'role:ep']], function(){
    Route::get('/ep/dashboard', [EpDashboardController::class, 'index'])->name('ep-dashboard');

    Route::get('/ep/script', [EpScriptController::class, 'index'])->name('ep-script');
    Route::post('/ep/script', [EpScriptController::class, 'store'])->name('ep-script');
    Route::get('/ep/script/{id}', [EpScriptController::class, 'download'])->name('ep-download');

    Route::resource('schedules', EpScheduleController::class);
    Route::post('add-jingle', [EpScheduleController::class, 'add_jingle'])->name('add-jingle');
    Route::post('/schedules/engineer', [EpScheduleController::class, 'engineer'])->name('assign-engineer');
    Route::resource('jingles', JingleController::class);
    Route::resource('finances', FinanceController::class);
    Route::resource('ep-adverts', \App\Http\Controllers\Ep\AdvertController::class);
});

Route::group(['middleware' => ['auth', 'role:presenter']], function(){
    Route::get('/presenter/dashboard', [PresenterDashboardController::class, 'index'])->name('presenter-dashboard');

    Route::resource('playlists', PresenterPlaylistController::class);
    Route::post('playlist-remove', [PresenterPlaylistController::class, 'remove'])->name('playlist-remove');
    Route::resource('scripts', PresenterScriptController::class);

    Route::get('/presenter/schedule', [PresenterScheduleController::class, 'index'])->name('presenter-schedule');
    Route::get('/presenter/schedule/{id}', [PresenterScheduleController::class, 'show'])->name('presenter-show-schedule');
});

Route::group(['middleware' => ['auth', 'role:audience']], function(){
    Route::get('/audience/dashboard', [DashboardController::class, 'index'])->name('audience-dashboard');
    Route::post('/audience/comment', [DashboardController::class, 'comment'])->name('audience-comment');
    Route::get('/audience/like/{id}', [DashboardController::class, 'like'])->name('audience-like');
    Route::resource('adverts', AdvertController::class);
});

Route::group(['middleware' => ['auth', 'role:engineer']], function(){
    Route::get('/eng/dashboard', [\App\Http\Controllers\Eng\DashboardController::class, 'index'])->name('eng-dashboard');
});

require __DIR__.'/auth.php';
