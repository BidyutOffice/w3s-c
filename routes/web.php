<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\HomeController;
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

Route::prefix("admin")->middleware("auth")->group(function () {
    Route::get('/dashboard', [AdminController::class, "dashboard"])->name("admin.dashboard");

    Route::resources([
        "subjects" => SubjectController::class,
        "topics" => TopicController::class,
        "contents" => ContentController::class,
    ]);
});

Route::prefix("student")->group(function () {
    Route::get("/dashboard", [StudentController::class, "dashboard"])->name("student.dashboard");
    Route::get("/profile", [StudentController::class, "profile"])->name("student.profile");
});
