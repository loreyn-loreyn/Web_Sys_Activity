<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Resume;

// check session status
Route::get('/session-status', function (Request $request) {
    return response()->json(['authenticated' => Auth::check()]);
})->name('session.status');

Route::get('/', function () {
    return redirect()->route('login');
});

// Preview resume without login
Route::get('/resume/preview/{user_id}', [ResumeController::class, 'preview'])->name('resume.preview');

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ✅ Only authenticated users can see resume
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    // show resume
    Route::get('/resume', [ResumeController::class, 'show'])->name('resume.show');

    // edit resume
    Route::get('/resume/edit', [ResumeController::class, 'edit'])->name('resume.edit');

    // update resume
    Route::post('/resume/update', [ResumeController::class, 'update'])->name('resume.update');
});
