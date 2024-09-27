<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;
use TomatoPHP\FilamentTranslations\Http\Middleware\LanguageMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

$middleware = [
    'auth:web',
    'web',
];
if (class_exists(LanguageMiddleware::class)) {
    $middleware[] = LanguageMiddleware::class;
}

Route::middleware($middleware)->group(function () {
    Route::get('orders/{model}/print', function (Order $model) {
        return view('orders.print', compact('model'));
    })->name('order.print');
});
