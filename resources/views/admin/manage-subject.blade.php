@extends('layouts.admin')
@section('main')
    <!-- Label for the Form -->
    <h2 class="text-lg font-bold mb-2">Add New Subject</h2>

    <!-- Success and Error Messages -->
    <x-flash-message />

    <!-- Form to Add Subject -->
    <form class="flex flex-wrap items-stretch py-3 text-gray-100 gap-4 bg-transparent rounded-lg mb-8"
        action="{{ route('subjects.store') }}" method="POST">
        @csrf
        <div class="flex-1">
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Subject"
                class="w-full p-2 bg-slate-700 outline-none rounded-lg focus:ring focus:ring-blue-500">
            @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex-auto">
            <textarea name="description" id="description" rows="1" placeholder="Description"
                class="w-full p-2 bg-slate-700 outline-none rounded-lg focus:ring focus:ring-blue-500">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Save
            </button>
        </div>
    </form>

    <!-- Label for the Table -->
    <h2 class="text-lg font-bold mb-4">Subjects List</h2>

    <!-- Table to Display Subjects -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-800 text-left">
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Description</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as $index => $subject)
                    <tr class="">
                        <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ ucwords($subject->name) }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $subject->description }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="flex space-x-2">
                                <a href="{{ route('subjects.edit', $subject->slug) }}"
                                    class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('subjects.destroy', $subject->slug) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600"
                                        onclick="return confirm('Are you sure you want to delete this subject?');">
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
            {{ $subjects->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
