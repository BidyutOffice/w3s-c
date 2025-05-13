<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Welcome To W3S-C')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.tiny.cloud/1/14elrc4bfiukjypfvbkt44w1228irvuaiqzag73aoa8wi920/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav id="header" class="bg-gray-800 text-gray-100 p-2">
        <div class="mx-auto px-4 bg-gray-900 sm:px-6 lg:px-8 flex justify-between items-center py-4 rounded-md">
            <!-- Panel Title -->
            <div class="text-2xl font-bold text-white uppercase tracking-widest" id="panel-title">Admin Panel</div>

            <!-- Navigation Links -->
            <div class="flex items-center gap-6 ms-auto">
                <a href="{{ route('logout') }}" class="text-sm text-gray-300 hover:text-white px-4 py-2">Logout</a>

                <!-- Theme Toggle Button -->
                <button id="theme-toggle" class="text-xl bg-transparent border-0 cursor-pointer">
                    <i class="bi bi-moon-fill" id="theme-icon"></i>
                </button>
            </div>
        </div>
    </nav>
    <div class="w-full grid grid-cols-fixed-two gap-5 bg-gray-800 p-2">
        <aside id="sidebar"
            class="w-full h-pannel-fixed overflow-y-auto bg-gray-900 p-6 flex flex-col gap-6 shadow-lg rounded-md">
            <!-- Sidebar Header -->
            {{-- <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-white uppercase tracking-widest">
                    Admin Panel
                </span>
            </div> --}}

            <!-- Navigation Links -->
            <nav class="flex flex-col gap-1">

                <a class="flex items-center gap-3 text-lg font-medium capitalize text-white hover:bg-gray-800 hover:pl-4 transition-all duration-300 ease-in-out rounded-md p-2"
                    href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>

                <!-- Manage Students Collapse -->
                <div class="flex flex-col">
                    <button type="button" onclick="toggleMenu('studentMenu')"
                        class="flex items-center justify-between text-lg font-medium capitalize text-white hover:bg-gray-800 hover:pl-4 transition-all duration-300 ease-in-out rounded-md p-2 w-full text-left">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-person"></i>
                            Students
                        </div>
                        <i id="studentMenuIcon" class="bi bi-chevron-down"></i>
                    </button>
                    <div id="studentMenu" class="ml-8 flex-col gap-1 mt-1 hidden">
                        <a href="{{ route('students.create') }}"
                            class="text-white hover:underline transition duration-200">Add Student</a>
                        <a href="{{ route('students.index') }}"
                            class="text-white hover:underline transition duration-200">Manage Students</a>
                    </div>
                </div>
                <!-- Manage Payments Collapse -->
                <div class="flex flex-col">
                    <button type="button" onclick="toggleMenu('paymentsMenu')"
                        class="flex items-center justify-between text-lg font-medium capitalize text-white hover:bg-gray-800 hover:pl-4 transition-all duration-300 ease-in-out rounded-md p-2 w-full text-left">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-person"></i>
                            Payments
                        </div>
                        <i id="paymentsMenuIcon" class="bi bi-chevron-down"></i>
                    </button>
                    <div id="paymentsMenu" class="ml-8 flex-col gap-1 mt-1 hidden">
                        <a href="{{ route('payments.create') }}"
                            class="text-white hover:underline transition duration-200">Make Payment</a>
                        <a href="{{ route('admin.payment') }}"
                            class="text-white hover:underline transition duration-200">Manage Payments</a>
                    </div>
                </div>

                <a class="flex items-center gap-3 text-lg font-medium capitalize text-white hover:bg-gray-800 hover:pl-4 transition-all duration-300 ease-in-out rounded-md p-2"
                    href="{{ route('subjects.index') }}">
                    <i class="bi bi-book"></i>
                    Subjects
                </a>

                <a class="flex items-center gap-3 text-lg font-medium capitalize text-white hover:bg-gray-800 hover:pl-4 transition-all duration-300 ease-in-out rounded-md p-2"
                    href="{{ route('topics.index') }}">
                    <i class="bi bi-list-task"></i>
                    Topics
                </a>

                <!--  Contents Collapse -->
                <div class="flex flex-col">
                    <button type="button" onclick="toggleMenu('contentMenu')"
                        class="flex items-center justify-between text-lg font-medium capitalize text-white hover:bg-gray-800 hover:pl-4 transition-all duration-300 ease-in-out rounded-md p-2 w-full text-left">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-file-earmark-text"></i>
                            Contents
                        </div>
                        <i id="contentMenuIcon" class="bi bi-chevron-down"></i>
                    </button>
                    <div id="contentMenu" class="ml-8 flex-col gap-1 mt-1 hidden">
                        <a href="{{ route('contents.create') }}"
                            class="text-white hover:underline transition duration-200">Add Content</a>
                        <a href="{{ route('contents.index') }}"
                            class="text-white hover:underline transition duration-200"> Contents</a>
                    </div>
                </div>

                <a class="flex items-center gap-3 text-lg font-medium capitalize text-white hover:bg-gray-800 hover:pl-4 transition-all duration-300 ease-in-out rounded-md p-2"
                    href="{{ route('courses.index') }}">
                    <i class="bi bi-mortarboard"></i>
                    Courses
                </a>

            </nav>

        </aside>
        <main class="w-full bg-gray-900 text-gray-100 p-6 h-pannel-fixed overflow-y-auto rounded-lg shadow-lg">
