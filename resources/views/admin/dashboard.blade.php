@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('main')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Example Card 1 -->
            <div class="bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-200">Users</h2>
                <p class="text-gray-300">Manage registered users</p>
                <a href="#" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    View Users
                </a>
            </div>

            <!-- Example Card 2 -->
            <div class="bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-200">Reports</h2>
                <p class="text-gray-300">View and generate reports</p>
                <a href="#" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    View Reports
                </a>
            </div>

            <!-- Example Card 3 -->
            <div class="bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-200">Settings</h2>
                <p class="text-gray-300">Manage application settings</p>
                <a href="#" class="mt-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Manage Settings
                </a>
            </div>
        </div>
    </div>
@endsection
