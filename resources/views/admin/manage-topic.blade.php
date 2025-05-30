@extends('layouts.admin')
@section('main')
    <!-- Label for the Form -->
    <h2 class="text-lg font-bold mb-2">Add New Topic</h2>

    <!-- Success and Error Messages -->
    <x-flash-message />

    <!-- Form to Add Subject -->
    <form class="flex flex-wrap items-center text-slate-200 py-3 gap-4 bg-transparent rounded-lg mb-8"
        action="{{ route('topics.store') }}" method="POST">
        @csrf
        <div class="flex-1">
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Topic"
                class="w-full h-[42px] p-2 bg-slate-700 outline-none rounded-lg focus:ring focus:ring-blue-500">
            @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex-1">
            <select name="subject_id"
                class="w-full h-[42px] bg-slate-700 p-2 text-gray-200 outline-none rounded-lg focus:ring focus:ring-blue-500">
                <option class="text-gray-300" value="">Select One</option>
                @foreach ($subjects as $subject)
                    <option class="text-gray-300" value="{{ $subject->id }}">{{ ucwords($subject->name) }}</option>
                @endforeach
            </select>
            @error('subject_id')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex-auto">
            <input name="description" id="description" placeholder="Description" value="{{ old('description') }}"
                class="w-full h-[42px] bg-slate-700 p-2 outline-none rounded-lg focus:ring focus:ring-blue-500" />
            @error('description')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 h-[42px]">
                Save
            </button>
        </div>
    </form>

    <!-- Filter and Topics Table -->
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold">Topics List</h3>
        <select name="subject_id" id="filter_subject" data-base-url="{{ route('topics.index') }}"
            class="p-2 border border-gray-300 text-gray-800 outline-none rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">All Subjects</option>
            @foreach ($subjects as $subject)
                <option value="{{ $subject->slug }}" {{ request('sub') == $subject->slug ? 'selected' : '' }}>
                    {{ ucwords($subject->name) }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Table to Display Subjects -->
    <div class="overflow-x-auto">
        @if (count($topics) > 0)
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-800 text-left">
                        <th class="border border-gray-300 px-4 py-2">#</th>
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Order</th>
                        <th class="border border-gray-300 px-4 py-2">Description</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable_topic_list">
                    @foreach ($topics as $index => $topic)
                        <tr draggable={{ request('sub') != '' ? 'true' : 'flase' }} class=""
                            data-id="{{ $topic->id }}">
                            <td class="border
                            border-gray-300 px-4 py-2">{{ $index + 1 }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ ucwords($topic->name) }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $topic->sequence }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $topic->description }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('topics.edit', $topic->slug) }}"
                                        class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('topics.destroy', $topic->slug) }}" method="POST">
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
                {{ $topics->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <p class="text-lg text-gray-100">No topics found!</p>
        @endif
    </div>


@endsection

@section('script1')
    <script type="module">
        import
        initFilter
        from '/js/utils/filterModule.js';
        initFilter('filter_subject');
    </script>
    @if (request('sub') != '')
        <script type="module">
            import
            initTableSequenceReorder
            from '/js/utils/reorderTable.js';

            const routeUrl = "{{ route('topics.reorder') }}";
            initTableSequenceReorder('sortable_topic_list', routeUrl);
        </script>
    @endif
@endsection
