<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
    "as" => "dcat.admin."
], function () {
});
