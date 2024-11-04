<?php

use App\Http\Controllers\PostController;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::resource('posts',PostController::class);
Route::get('comment',function(){
    // return Request();
    Comment::create([
        'user_id' => auth()->user()->id,
        'post_id' => request('post_id'),
        'comment' => request('comment'),
    ]);

    return back();
})->name('comment.store');
