<?php

use App\Http\Controllers\AppController as AppController;

Route::get('{all}', [AppController::class, 'index'])->where('all', '^((?!api).)*')->name('index');
