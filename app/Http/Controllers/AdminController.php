<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $studentsCount = Student::where("status", "active")->count();
        return view("admin.dashboard", compact("studentsCount"));
    }
}
