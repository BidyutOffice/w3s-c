@extends('layouts.admin')
@section('main')
    <!-- Label for the Form -->
    <h2 class="text-lg font-bold mb-2">Add Course</h2>

    <!-- Success and Error Messages -->
    <x-flash-message />

    <!-- Form to Add Course -->
    <form class="flex flex-wrap items-stretch py-3 text-gray-100 gap-4 bg-transparent rounded-lg mb-8"
        action="{{ route('courses.store') }}" method="POST">
        @csrf

        <div class="flex-[2] min-w-[250px]">
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Course Name"
                class="w-full bg-slate-700 p-2 outline-none rounded-lg focus:ring focus:ring-blue-500">
            @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex-1 min-w-[200px]">
            <input type="text" name="code" id="code" value="{{ old('code') }}" placeholder="Course Code"
                class="w-full p-2 bg-slate-700 outline-none rounded-lg focus:ring focus:ring-blue-500">
            @error('code')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-full">
            <textarea name="description" id="description" rows="2" placeholder="Description"
                class="w-full p-2 h-full bg-slate-700 outline-none rounded-lg focus:ring focus:ring-blue-500">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex-1 min-w-[180px]">
            <input type="number" name="credits" id="credits" value="{{ old('credits') }}"
                placeholder="Credits (optional)"
                class="w-full outline-none bg-slate-700 p-2 rounded-lg focus:ring focus:ring-blue-500">
            @error('credits')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex-1 min-w-[180px]">
            <input type="number" name="base_price" id="base_price" step="0.01" value="{{ old('base_price') }}"
                placeholder="Base Price (₹)"
                class="w-full outline-none bg-slate-700 p-2 rounded-lg focus:ring focus:ring-blue-500">
            @error('base_price')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex-1 min-w-[180px]">
            <input type="number" name="duration_weeks" id="duration_weeks" value="{{ old('duration_weeks') }}"
                placeholder="Duration (weeks)"
                class="w-full outline-none bg-slate-700 p-2 rounded-lg focus:ring focus:ring-blue-500">
            @error('duration_weeks')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-full">
            <button type="submit" class="px-4 py-2 ms-auto bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Save
            </button>
        </div>
    </form>

    <!-- Label for the Table -->
    <h2 class="text-lg font-bold mb-4">Courses List</h2>

    <!-- Table to Display Subjects -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-800 text-left">
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Code</th>
                    <th class="border border-gray-300 px-4 py-2">Base Price</th>
                    <th class="border border-gray-300 px-4 py-2">Duration(W)</th>
                    <th class="border border-gray-300 px-4 py-2">Active Students</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $index => $course)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ route('courses.show', $course->slug) }}">
                                {{ ucwords($course->name) }}
                            </a>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $course->code }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $course->base_price }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $course->duration_weeks }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            @php
                                $activeCount = $course->getActiveStudentCount();
                            @endphp

                            @if ($activeCount > 0)
                                <a href="{{ route('students.index', ['course' => $course->code, 'status' => 'active']) }}"
                                    class="text-blue-600 text-lg hover:underline">
                                    {{ $activeCount }}
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="flex space-x-2">
                                <a href="{{ route('courses.edit', $course->slug) }}"
                                    class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('courses.destroy', $course->slug) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600"
                                        onclick="return confirm('Are you sure you want to delete this course?');">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $courses->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
