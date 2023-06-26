<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// // closure
Route::get('/', function () {
    // blade es el     template engine     de laravel
    return view('home'); // /resources/views/file.blade.php <- renderiza la view
});



// // // controllers
Route::get('/register', [RegisterController::class, 'index'])->name('register'); // [class controller, method] ->name('name') <- tomarlo en la view y asi tenerlo dinamico
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'init'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LogoutController::class, 'store'])->name('logout');


// // route model binding: path dinamico relacionado a 1 Model 
// x default va a tomar el id para el path, pero asi podemos referirnos a cualquier column de la tabla asociada al model - ahora init() espera 1 User
Route::get('/{user:username}', [PostController::class, 'init'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show'); // show: render record view
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');


// // images
Route::post('/images', [ImageController::class, 'store'])->name('images.store');


// // comments
Route::post('/{user:username}/posts/{post}', [CommentController::class, 'store'])->name('comments.store');
