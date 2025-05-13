@extends('layouts.admin')

@section('main')
    <h2 class="text-2xl font-bold mb-6 text-white">Student Details</h2>

    <x-flash-message />

    <div class="mx-auto shadow-md mt-4 space-y-6">

        <!-- 🔵 Personal Details -->
        <div class="bg-slate-800 rounded-xl p-6 shadow">
            <h3 class="text-xl font-semibold text-white mb-4 border-b pb-2 border-slate-600">🧍 Personal Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-200">
                <div><strong>Name:</strong> {{ ucwords($student->first_name . ' ' . $student->last_name) }}</div>
                <div><strong>Registration ID:</strong> {{ $student->reg_id }}</div>
                <div><strong>Email:</strong> {{ $student->email }}</div>
                <div><strong>Phone:</strong>
                    @if ($student->phone_number)
                        {{ substr($student->phone_number, 0, 4) }}-{{ substr($student->phone_number, 4, 3) }}-{{ substr($student->phone_number, 7, 3) }}
                    @else
                        {{ 'N/A' }}
                    @endif
                </div>
                <div><strong>Date of Birth:</strong>
                    {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') : 'N/A' }}
                </div>
                <div><strong>Status:</strong> {{ ucfirst($student->status) }}</div>
                <div class="md:col-span-2 capitalize"><strong>Address:</strong> {{ $student->address }},
                    {{ $student->city }},
                    {{ $student->state }} - {{ $student->zip_code }}</div>
            </div>
        </div>

        <!-- 📚 Courses -->
        <div class="bg-slate-800 rounded-xl p-6 shadow">
            <h3 class="text-xl font-semibold text-white mb-4 border-b pb-2 border-slate-600">📚 Courses Enrolled</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($student->courses as $course)
                    <div class="p-4 rounded-lg">
                        <h4 class="text-lg font-semibold text-white">{{ $course->name }}</h4>
                        <p class="text-sm text-gray-300">Code: {{ $course->code }}</p>
                        <p class="text-sm text-gray-300">Sold Price: ₹{{ number_format($course->pivot->sold_price, 2) }}
                        </p>
                        <p class="text-sm text-gray-300">Discount: {{ $course->pivot->discount }}%</p>
                    </div>
                @empty
                    <p class="text-gray-300">No courses enrolled.</p>
                @endforelse
            </div>
        </div>

        <!-- Include Payment Details Component -->
        <x-payment-details :student="$student" />

        <!-- Include Payment History Component -->
        <x-payment-history :student="$student" />

        <!-- 🔙 Back Button -->
        <div class="mt-8">
            <a href="{{ route('students.index') }}"
                class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
                ⬅ Back to List
            </a>
        </div>
    </div>
@endsection
