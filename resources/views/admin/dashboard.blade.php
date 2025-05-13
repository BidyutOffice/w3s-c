@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('main')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Active Students Card -->
            <div class="bg-slate-800 border border-slate-800 rounded-xl shadow p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-200">Active Students</h2>
                    <span class="text-sm font-medium bg-green-100 text-green-800 px-2 py-1 rounded-full">
                        {{ $studentsCount }}
                    </span>
                </div>
                <p class="text-slate-300 mb-4">Total number of active students enrolled.</p>
                <a href="{{ route('students.index') }}"
                    class="inline-block text-sm bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md font-medium transition">
                    View Students
                </a>
            </div>

            <!-- Reports Card -->
            <div class="bg-slate-800 border border-slate-800 rounded-xl shadow p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-200">Reports</h2>
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m4 0H5" />
                    </svg>
                </div>
                <p class="text-slate-300 mb-4">View or generate performance and attendance reports.</p>
                <a href="#"
                    class="inline-block text-sm bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md font-medium transition">
                    View Reports
                </a>
            </div>

            <!-- Settings Card -->
            <div class="bg-slate-800 border border-slate-800 rounded-xl shadow p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-200">Settings</h2>
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m0 14v1m8.485-8.485h-1m-14 0h-1m10.364-5.364l-.707.707M6.343 17.657l-.707.707m0-13.071l.707.707m11.314 11.314l.707.707" />
                    </svg>
                </div>
                <p class="text-slate-300 mb-4">Manage system preferences and access controls.</p>
                <a href="#"
                    class="inline-block text-sm bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md font-medium transition">
                    Manage Settings
                </a>
            </div>

        </div>
    </div>
@endsection
