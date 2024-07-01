<?php

use App\Http\Controllers\CutomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\TaskMangementContoller;
use App\Http\Controllers\SellerContoller;
use App\Http\Controllers\BuyerContoller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Storage;


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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return redirect(route('login'));
});
Route::get('/writer-signup', function () {
    return view('auth.writer_signup');
})->name('auth.writer_signup');
Route::get('/buyer-signup', function () {
    return view('auth.buyer_signup');
})->name('auth.buyer_signup');
Route::post('writer-signup-store', [RegisterController::class, 'writerSignup'])->name('writerSignup');
Route::post('buyer-signup-store', [RegisterController::class, 'buyerSignup'])->name('buyerSignup');


Route::group(['middleware' => ['auth']], function() {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::patch('/profile-update', [UserController::class, 'profileUpdate'])->name('updateProfile');
    
    Route::resource('customer', CutomerController::class);
    Route::resource('plan', PlanController::class);
    Route::get('/plan/change-status/{id}/{status}', [PlanController::class, 'changeStatus'])->name('plan.changeStatus');
    Route::get('tasks/assign', [TaskMangementContoller::class, 'assignTask'])->name('tasks.assign');
    Route::post('tasks/assign', [TaskMangementContoller::class, 'assignTaskStore'])->name('tasks.assignTaskStore');

    
    Route::get('tasks/unassign', [TaskMangementContoller::class, 'unAssignTask'])->name('tasks.unassign');
    Route::get('tasks/review-task', [TaskMangementContoller::class, 'reviewTask'])->name('tasks.reviewTask');
    Route::get('tasks/complete-tasks', [TaskMangementContoller::class, 'completeTask'])->name('tasks.completeTask');
    Route::get('tasks/pending-task', [TaskMangementContoller::class, 'pendingTask'])->name('tasks.pendingTask');
    Route::get('tasks/rejected-task', [TaskMangementContoller::class, 'rejectedTask'])->name('tasks.rejectedTask');
    Route::get('tasks/report', [TaskMangementContoller::class, 'report'])->name('tasks.report');
    Route::get('/tasks/status/{id}/{status}', [TaskMangementContoller::class, 'changeStatus'])->name('tasks.status');
    Route::get('/tasks/report', [TaskMangementContoller::class, 'report'])->name('tasks.report');
    Route::get('/tasks/import', function () {
        return view('tasks.import');
    })->name('tasks.import');
    Route::post('/tasks/import', [TaskMangementContoller::class, 'taskImport']);
    Route::get('/download-sample', function () {
        return response()->download($_SERVER['DOCUMENT_ROOT'].'/import-task.csv', 'import-task-sample.csv');
    })->name('tasks.downloadSample');
    
    Route::resource('tasks', TaskMangementContoller::class);
    Route::get('/writers', [SellerContoller::class, 'index'])->name('writers.index');
    Route::get('/writers/edit/{id}', [SellerContoller::class, 'edit'])->name('writers.edit');
    Route::post('/writers/edit/{id}', [SellerContoller::class, 'update']);
    Route::get('/writers/show/{id}', [SellerContoller::class, 'show'])->name('writers.show');
    Route::get('/buyers', [BuyerContoller::class, 'index'])->name('buyers.index');
    Route::get('/buyers/edit/{id}', [BuyerContoller::class, 'edit'])->name('buyers.edit');
    Route::post('/buyers/edit/{id}', [BuyerContoller::class, 'update']);
    Route::get('/buyers/view/{id}', [BuyerContoller::class, 'view'])->name('buyers.view');
    Route::post('/add-article', [ArticleController::class, 'addArticle'])->name('addArticle');
    Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
    Route::get('/articles/start-writing/{id}/', [ArticleController::class, 'create'])->name('article.create');
    Route::post('/articles/start-writing/', [ArticleController::class, 'store'])->name('article.store');
    Route::post('/articles/comment', [ArticleController::class, 'articleComment'])->name('articles.comment');
    Route::get('/articles/view/{id}', [ArticleController::class, 'articleView'])->name('articles.view');
    Route::get('/articles/download/{id}', [ArticleController::class, 'downloadArticle'])->name('article.download');

});


