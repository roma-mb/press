<?php

use RomaMb\Press\Facades\Press;
use RomaMb\Press\Http\Controllers\BlogController;

Route::group(
    [
        'prefix' => Press::path(),
    ],
    static function () {
        Route::view('blog', 'press::index');
        Route::get('controller', [BlogController::class, 'index']);
    }
);
