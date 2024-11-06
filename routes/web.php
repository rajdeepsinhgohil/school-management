<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware('isAdmin')->group(function () {
        Route::get('/teacher', [\App\Http\Controllers\TeacherController::class, 'index'])->name('teacher.list');
        Route::get('/teacher-add', [\App\Http\Controllers\TeacherController::class, 'createView'])->name('teacher.add');
        Route::post('/teacher-add', [\App\Http\Controllers\TeacherController::class, 'saveTeacher'])->name('teacher.save');
        Route::get('/teacher-edit/{id}', [\App\Http\Controllers\TeacherController::class, 'editView'])->name('teacher.edit');
        Route::post('/teacher-update', [\App\Http\Controllers\TeacherController::class, 'editTeacher'])->name('teacher.update');
        Route::get('/teacher-delete/{id}', [\App\Http\Controllers\TeacherController::class, 'delete'])->name('teacher.delete');
        Route::get('/teacher/announcements-delete/{id}', [\App\Http\Controllers\TeacherController::class, 'delete'])->name('teacher.announcements');

        Route::get('/announcement', [\App\Http\Controllers\TeacherAnnouncementController::class, 'index'])->name('teacher.announcement.list');
        Route::get('/announcement-add', [\App\Http\Controllers\TeacherAnnouncementController::class, 'createView'])->name('teacher.announcement.add');
        Route::post('/announcement-add', [\App\Http\Controllers\TeacherAnnouncementController::class, 'saveAnnouncement'])->name('teacher.announcement.save');
        Route::get('teacher/announcement/{id}', [\App\Http\Controllers\TeacherAnnouncementController::class, 'viewTeacherAnnouncement'])->name('specific.teacher.announcement.list');
    });

    Route::get('/students', [\App\Http\Controllers\StudentController::class, 'index'])->name('student.list');
    Route::get('/student-add', [\App\Http\Controllers\StudentController::class, 'createView'])->name('student.add');
    Route::post('/student-add', [\App\Http\Controllers\StudentController::class, 'saveStudent'])->name('student.save');
    Route::get('/student-edit/{id}', [\App\Http\Controllers\StudentController::class, 'editView'])->name('student.edit');
    Route::post('/student-update', [\App\Http\Controllers\StudentController::class, 'editStudent'])->name('student.update');
    Route::get('/student-delete/{id}', [\App\Http\Controllers\StudentController::class, 'delete'])->name('student.delete');

    Route::get('/parent', [\App\Http\Controllers\ParentController::class, 'index'])->name('parent.list');
    Route::get('/parent-add', [\App\Http\Controllers\ParentController::class, 'createView'])->name('parent.add');
    Route::post('/parent-add', [\App\Http\Controllers\ParentController::class, 'saveParent'])->name('parent.save');
    Route::get('/parent-edit/{id}', [\App\Http\Controllers\ParentController::class, 'editView'])->name('parent.edit');
    Route::post('/parent-update', [\App\Http\Controllers\ParentController::class, 'editPado@rent'])->name('parent.update');
    Route::get('/parent-delete/{id}', [\App\Http\Controllers\ParentController::class, 'delete'])->name('parent.delete');

    Route::get('/announcement-mark-read/{id}', [\App\Http\Controllers\TeacherAnnouncementController::class, 'markAsRead'])->name('mark-read');

    Route::get('/student-announcement', [\App\Http\Controllers\StudentController::class, 'announcementList'])->name('student.announcement.list');
    Route::get('/student-announcement-add', [\App\Http\Controllers\StudentController::class, 'announcementAdd'])->name('student.announcement.add');
    Route::post('/student-announcement-add', [\App\Http\Controllers\StudentController::class, 'saveAnnouncement'])->name('student.announcement.save');

//    Route::get('/parents', [\App\Http\Controllers\ParentsController::class, 'index'])->name('parent.list');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
