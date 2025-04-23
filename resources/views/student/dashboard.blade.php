@extends('layouts.student')
@section('title', 'John Doe’s Learning Dashboard')
@section('main')
    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="text-3xl font-bold mb-4">Welcome, Student!</h1>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-bold">Completed Courses</h2>
                <p class="text-2xl">5</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-bold">Pending Projects</h2>
                <p class="text-2xl">2</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-bold">Study Hours</h2>
                <p class="text-2xl">15 hrs/week</p>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white p-6 rounded shadow h-96">
            <h2 class="text-xl font-bold mb-4">Weekly Study Progress</h2>
            <canvas id="studyChart" class="w-full h-full"></canvas>
        </div>
    </main>
@endsection
