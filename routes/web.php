<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PostController;
use \App\Http\Controllers\RatingController;
use \App\Http\Controllers\CommentController;
use \App\Http\Controllers\SearchController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\TagController;
use \App\Http\Controllers\ContactMessageController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\NavigationAdministrationController;
use \App\Http\Controllers\MenuController;
use \App\Http\Controllers\MenuItemController;
use \App\Http\Controllers\AvailableNavigationItemsController;
use \App\Http\Controllers\DisplayCategoryTagsAdministrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/', function () {
//    return view('home');
//});

Auth::routes();

require __DIR__.'/auth.php';

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'search']);
Route::get('/contact', [ContactMessageController::class, 'index']);
Route::post('/contact-messages', [ContactMessageController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/rate/{object}/{id}/{action}', [RatingController::class, 'rate']);
    Route::resources([
        'comments' => CommentController::class,
    ]);
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/navigation', NavigationAdministrationController::class)->name('navigation.index');
    Route::resources([
        'menu-items' => MenuItemController::class
    ]);
    Route::get('/navigation-items', AvailableNavigationItemsController::class)->name('navigation-items');
    Route::get('/contact-messages', [ContactMessageController::class, 'adminIndex'])->name('contact-message.admin.index');
    Route::post('/contact-messages/{contactMessage}/reply', [ContactMessageController::class, 'reply'])->name('reply');
    Route::get('/tag-categories-administration', DisplayCategoryTagsAdministrationController::class)->name('tag-categories-administration');
});

Route::resources([
    'posts' => PostController::class,
    'categories' => CategoryController::class,
    'tags' => TagController::class,
    'users' => UserController::class,
    'menus' => MenuController::class
]);

//Auth::routes();
