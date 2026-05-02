<?php

use App\Http\Controllers\Datastream\DatastreamController;
use App\Http\Controllers\Datastream\ManageDatastreamController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::get('datastream', [DatastreamController::class, 'index'])
    ->name('datastream.index');

Route::get('datastream/{datastreamPost:slug}', [DatastreamController::class, 'show'])
    ->name('datastream.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::get('dashboard/datastream', [ManageDatastreamController::class, 'index'])
        ->name('dashboard.datastream.index');

    Route::get('dashboard/datastream/create', [ManageDatastreamController::class, 'create'])
        ->name('dashboard.datastream.create');

    Route::post('dashboard/datastream', [ManageDatastreamController::class, 'store'])
        ->name('dashboard.datastream.store');

    Route::get('dashboard/datastream/{datastreamPost}/edit', [ManageDatastreamController::class, 'edit'])
        ->name('dashboard.datastream.edit');

    Route::put('dashboard/datastream/{datastreamPost}', [ManageDatastreamController::class, 'update'])
        ->name('dashboard.datastream.update');

    Route::delete('dashboard/datastream/{datastreamPost}', [ManageDatastreamController::class, 'destroy'])
        ->name('dashboard.datastream.destroy');
});

require __DIR__.'/settings.php';