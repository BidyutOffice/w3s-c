<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManageStudentesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, "welcome"])->name("welcome");

Route::prefix("auth")->group(function () {
    Route::get("/register", [AuthController::class, "registerView"])->name("register.page");
    Route::post("/register", [AuthController::class, "register"])->name("register");
    Route::get("/login", [AuthController::class, "loginView"])->name("login.page");
    Route::post("/login", [AuthController::class, "login"])->name("login");
    Route::get("/logout", [AuthController::class, "logout"])->name("logout");
});

Route::prefix("admin")->middleware("admin")->group(function () {
    Route::get('/dashboard', [AdminController::class, "dashboard"])->name("admin.dashboard");

    Route::get("/payments", [PaymentsController::class, "index"])->name("admin.payment");
    Route::get('/payments/create', [PaymentsController::class, 'create'])->name('payments.create');
    Route::post('/payments/search-student', [PaymentsController::class, 'searchStudent'])->name('payments.searchStudent');
    Route::post('/payments/store', [PaymentsController::class, 'store'])->name('payments.store');

    Route::resources([
        "subjects" => SubjectController::class,
        "topics" => TopicController::class,
        "contents" => ContentController::class,
        "courses" => CourseController::class,
        "students" => ManageStudentesController::class,
    ]);
    Route::post('/topics/reorder', [TopicController::class, 'reorder'])->name('topics.reorder');

    Route::get('/courses/{course}/subjects/attach', [CourseController::class, 'attachForm'])->name('courses.subjects.attach');
    Route::post('/courses/{course}/subjects/attach', [CourseController::class, 'attach'])->name('courses.subjects.attach.store');
    Route::delete('/courses/{course}/subjects/{subject}', [CourseController::class, 'detach'])->name('courses.subjects.detach');
});

Route::prefix("student")->middleware('student')->group(function () {
    Route::get("/dashboard", [StudentController::class, "dashboard"])->name("student.dashboard");
    Route::get("/profile", [StudentController::class, "profile"])->name("student.profile");
    Route::get("course-and-payments", [StudentController::class, "courseAndPayments"])->name("student.courseAndPayments");
    Route::get('payments/pdf', [StudentController::class, 'downloadPaymentsPDF'])->name('student.payments.pdf');
});
