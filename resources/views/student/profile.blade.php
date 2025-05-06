@extends('layouts.student')
@section('title', 'About Rahul Roy - Student & Aspiring Professional')
@section('main')
    <div class="max-w-5xl mx-auto p-6 sm:p-10 rounded-lg space-y-4">

        <div class="flex flex-col sm:flex-row items-center gap-6">
            <img src="{{ asset('images/user-icon.png') }}" alt="Profile Picture"
                class="w-28 h-28 rounded-full border-4 border-indigo-500 object-cover">

            <div class="text-center sm:text-left">
                <h1 class="text-3xl font-bold text-gray-800 uppercase">
                    {{ $student->first_name }} {{ $student->last_name }}
                </h1>
                <p class="text-lg text-gray-500 capitalize">{{ $student->gender }}</p>
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg">
            <h2 class="text-xl font-semibold text-indigo-700 mb-3">Basic Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700">
                <div><strong>Registration ID:</strong> {{ $student->reg_id }}</div>
                <div><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($student->date_of_birth)->format('F d, Y') }}
                </div>
                <div><strong>Status:</strong> <span class="capitalize">{{ $student->status }}</span></div>
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg">
            <h2 class="text-xl font-semibold text-indigo-700 mb-3">Contact Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700">
                <div><strong>Email:</strong> {{ $student->email }}</div>
                <div>
                    <strong>Phone:</strong>
                    {{ substr($student->phone_number, 0, 4) }}-{{ substr($student->phone_number, 4, 3) }}-{{ substr($student->phone_number, 7, 3) }}
                </div>
                <div class="sm:col-span-2 capitalize flex gap-1">
                    <strong>Address:</strong>
                    <span>
                        {{ $student->address }}, {{ $student->city }}<br /> {{ $student->state }} -
                        {{ $student->zip_code }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg">
            <h2 class="text-xl font-semibold text-indigo-700 mb-3">About Me</h2>
            <p class="text-gray-700 leading-relaxed">
                I'm a passionate student from {{ $student->city }}, {{ $student->state }}. I enjoy learning and growing my
                knowledge every day.
            </p>
        </div>

        {{-- <div class="p-6">
            <h2 class="text-xl font-semibold text-indigo-700 mb-3">Course Information</h2>
            @forelse ($student->courses as $course)
                <div class="bg-gray-50 p-4 rounded-lg mb-2">
                    <h4 class="text-lg font-semibold text-gray-800">{{ $course->name }}</h4>
                    <p class="text-sm text-gray-700">Code: {{ $course->code }}</p>
                    <p class="text-sm text-gray-700">Sold Price: ₹{{ number_format($course->pivot->sold_price, 2) }}</p>
                    <p class="text-sm text-gray-700">Discount: {{ $course->pivot->discount }}%</p>
                </div>
            @empty
                <p class="text-gray-500">No courses enrolled.</p>
            @endforelse
        </div> --}}
    </div>
@endsection
