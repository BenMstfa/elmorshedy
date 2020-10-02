<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::redirect('/dashboard', '/projects');
Route::get('/', [WebsiteController::class, 'index'])->name('index');
Route::get('/project/{id}/details', [WebsiteController::class, 'projectDetails'])->name('project.details');


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects');
    Route::post('/projects/datatable', [ProjectsController::class, 'datatable']);
    Route::get('/projects/create', [ProjectsController::class, 'create']);
    Route::post('/project/store', [ProjectsController::class, 'store']);
    Route::get('/project/{id}/update', [ProjectsController::class, 'getUpdate']);
    Route::post('/project/{id}/update', [ProjectsController::class, 'update']);
    Route::post('/project/{id}/delete', [ProjectsController::class, 'delete']);
});

Route::get('/language/switch/{lang}', function ($lang) {
    App::setLocale($lang);

    return redirect()->back()->withCookie(cookie()->forever('locale', $lang));

})->name('language.switch');
