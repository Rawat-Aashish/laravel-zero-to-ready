<?php

use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    return __('messages.localization_test');
});