<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CausesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsStoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/projects', [PublicController::class, 'projects'])->name('public.projects');
Route::get('/projects/{slug}', [PublicController::class, 'showProject'])->name('public.projects.show');

Route::get('/causes', [App\Http\Controllers\PublicController::class, 'causes'])->name('public.causes');
Route::get('/causes/{slug}', [App\Http\Controllers\PublicController::class, 'showCause'])->name('public.causes.show');

Route::get('/events', [App\Http\Controllers\PublicController::class, 'events'])->name('public.events');
Route::get('/events/{event}', [App\Http\Controllers\PublicController::class, 'showEvent'])->name('public.events.show');

Route::get('/news-stories', [App\Http\Controllers\PublicController::class, 'news'])->name('public.news');
Route::get('/news-stories/{event}', [App\Http\Controllers\PublicController::class, 'showNews'])->name('public.showNews.show');

Route::get('/contact', [App\Http\Controllers\PublicController::class, 'contact'])->name('public.contact');
Route::post('/contact', [App\Http\Controllers\PublicController::class, 'submitContact'])->name('public.contact.submit');



Route::get('/about', function () {
    return Inertia::render('Public/About');
});
Route::get('/donate', function () {
    return Inertia::render('Public/Donate');
});

Route::get('/blog', function () {
    return Inertia::render('Public/Blog/Index');
});

Route::get('/volunteer', function () {
    return Inertia::render('Public/Volunteer');
});

// Route::get('/admin/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Group your admin routes
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // This creates index, store, update, and destroy routes automatically
    Route::resource('projects', ProjectController::class)->except(['create', 'show', 'edit']);
    Route::resource('causes', CausesController::class)->except(['create', 'show', 'edit']);
    Route::resource('events', EventController::class)->except(['create', 'show', 'edit']);
    Route::resource('volunteers', VolunteerController::class)->except(['create', 'show', 'edit']);
    Route::resource('news-stories', NewsStoryController::class)->except(['create', 'show', 'edit']);
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');


    Route::get('/messages', [ContactController::class, 'index'])->name('admin.messages.index');
    Route::patch('/messages/{message}/status', [ContactController::class, 'updateStatus'])->name('admin.messages.status');
    Route::delete('/messages/{message}', [ContactController::class, 'destroy'])->name('admin.messages.destroy');
    Route::post('/messages/{message}/reply', [ContactController::class, 'reply'])->name('admin.messages.reply');



 });
 

Route::middleware(['auth'])->group(function () {  
    Route::post('/projects/{project}/comments', [App\Http\Controllers\CommentController::class, 'storeProjectComment'])->name('projects.comments.store');
    Route::post('/causes/{cause}/comments', [App\Http\Controllers\CommentController::class, 'storeCauseComment'])->name('causes.comments.store');
    Route::post('/events/{event}/comments', [App\Http\Controllers\CommentController::class, 'storeEventComment'])->name('events.comments.store');
});



require __DIR__.'/auth.php';
