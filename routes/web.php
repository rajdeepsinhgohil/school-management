<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/teacher', [\App\Http\Controllers\TeacherController::class, 'index'])->name('teacher.list');
    Route::get('/teacher-add', [\App\Http\Controllers\TeacherController::class, 'createView'])->name('teacher.add');
    Route::post('/teacher-add', [\App\Http\Controllers\TeacherController::class, 'saveTeacher'])->name('teacher.save');
    Route::get('/teacher-edit/{id}', [\App\Http\Controllers\TeacherController::class, 'editView'])->name('teacher.edit');
    Route::post('/teacher-update', [\App\Http\Controllers\TeacherController::class, 'editTeacher'])->name('teacher.update');
    Route::get('/teacher-delete/{id}', [\App\Http\Controllers\TeacherController::class, 'delete'])->name('teacher.delete');
//    Route::get('/teacher-edit', [\App\Http\Controllers\TeacherController::class, 'createView'])->name('teacher.edit');

    Route::get('/students', [\App\Http\Controllers\StudentController::class, 'index'])->name('student.list');
    Route::get('/parents', [\App\Http\Controllers\ParentsController::class, 'index'])->name('parent.list');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
