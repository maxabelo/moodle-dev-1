<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
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
// Route::get('/', function () {
//     // blade es el     template engine     de laravel
//     return view('home'); // /resources/views/file.blade.php <- renderiza la view
// });

Route::get('/', HomeController::class)->name('home');



// // // controllers
Route::get('/register', [RegisterController::class, 'index'])->name('register'); // [class controller, method] ->name('name') <- tomarlo en la view y asi tenerlo dinamico
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'init'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LogoutController::class, 'store'])->name('logout');


// // route model binding: path dinamico relacionado a 1 Model 
// x default va a tomar el id para el path, pero asi podemos referirnos a cualquier column de la tabla asociada al model - ahora init() espera 1 User
// Route::get('/{user:username}', [PostController::class, 'init'])->name('posts.index'); // al final
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show'); // show: render record view
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');


// // images
Route::post('/images', [ImageController::class, 'store'])->name('images.store');


// // comments
Route::post('/{user:username}/posts/{post}', [CommentController::class, 'store'])->name('comments.store');

// like photos
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');



// // Profile
Route::get('/edit-profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('/edit-profile', [ProfileController::class, 'store'])->name('profile.store');



// // following users
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');




// al final xq es dinamico, like in react, node, etc - tb podriamos validar x policy
Route::get('/{user:username}', [PostController::class, 'init'])->name('posts.index');
