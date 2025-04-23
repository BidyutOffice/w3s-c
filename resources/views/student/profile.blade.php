@extends('layouts.student')
@section('title', 'About Rahul Roy - Student & Aspiring Professional')
@section('main')
    <!-- Profile Container -->
    <div class="mx-auto p-8 rounded-lg shadow-md">

        <!-- Header: Name, Job Title, Profile Image -->
        <div class="flex items-center space-x-6">
            <img src="https://via.placeholder.com/100" alt="Profile Picture"
                class="w-24 h-24 rounded-full border-4 border-indigo-500">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">John Doe</h1>
                <p class="text-xl text-gray-600">Web Developer</p>
            </div>
        </div>

        <!-- Bio Section -->
        <div class="mt-8">
            <h2 class="text-2xl font-semibold text-gray-800">About Me</h2>
            <p class="mt-2 text-gray-700">I'm passionate about learning new technologies and applying them in the medical
                field. I strive to improve my skills every day and work towards making a positive impact in the world.</p>
        </div>

        <!-- Contact Section -->
        <div class="mt-8">
            <h2 class="text-2xl font-semibold text-gray-800">Contact Info</h2>
            <ul class="mt-2 text-gray-700">
                <li><strong>Email:</strong> johndoe@example.com</li>
                <li><strong>LinkedIn:</strong> <a href="#" class="text-indigo-600">linkedin.com/in/johndoe</a></li>
                <li><strong>GitHub:</strong> <a href="#" class="text-indigo-600">github.com/johndoe</a></li>
            </ul>
        </div>

        <!-- Skills Section -->
        <div class="mt-8">
            <h2 class="text-2xl font-semibold text-gray-800">Skills</h2>
            <ul class="mt-2 text-gray-700">
                <li>HTML, CSS, JavaScript</li>
                <li>React, Next.js</li>
                <li>Medical Data Analysis</li>
                <li>Problem Solving</li>
            </ul>
        </div>

        <!-- Achievements Section -->
        <div class="mt-8">
            <h2 class="text-2xl font-semibold text-gray-800">Achievements</h2>
            <ul class="mt-2 text-gray-700">
                <li>Completed Medical Technology Internship at XYZ Hospital</li>
                <li>Participated in University Hackathon - 1st Place</li>
                <li>Developed a web-based health management system for local clinics</li>
            </ul>
        </div>

    </div>
@endsection
