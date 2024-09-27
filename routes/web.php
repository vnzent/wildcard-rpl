<?php

use App\Http\Controllers\BuilderController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;
use ProtoneMedia\Splade\Http\SpladeMiddleware;
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

Route::middleware(['web', 'auth', SpladeMiddleware::class])->name('admin.')->group(function () {
    Route::get('admin/pages/{model}/builder', [BuilderController::class, 'builder'])->name('pages.builder');
    Route::post('admin/pages/{model}/sections', [BuilderController::class, 'sections'])->name('pages.sections');
    Route::post('admin/pages/{model}/sections/remove', [BuilderController::class, 'remove'])->name('pages.remove');
    Route::get('admin/pages/{model}/meta', [BuilderController::class, 'meta'])->name('pages.meta');
    Route::post('admin/pages/{model}/meta', [BuilderController::class, 'metaStore'])->name('pages.meta.store');
    Route::post('admin/pages/{model}/clear', [BuilderController::class, 'clear'])->name('pages.clear');
});
