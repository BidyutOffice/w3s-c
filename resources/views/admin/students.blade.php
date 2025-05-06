@extends('layouts.admin')
@section('main')
    <!-- Label for the Form -->
    <h2 class="text-lg font-bold mb-2">Students</h2>

    <x-flash-message />

    <!-- Filter and Topics Table -->
    <div class="flex items-center justify-end gap-4 mb-4">
        <form action="" method="get">
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Search"
                class="w-96 h-[42px] p-2 bg-slate-700 outline-none rounded-lg focus:ring focus:ring-blue-500">
        </form>
        <select name="subject_id" id="filter_course" data-base-url="{{ route('students.index') }}"
            class="p-2 bg-slate-700 text-gray-100 outline-none rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 h-[42px]">
            <option value="">All Courses</option>
            @foreach ($courses as $course)
                <option value="{{ $course->code }}" {{ request('course') == $course->code ? 'selected' : '' }}>
                    {{ ucwords($course->name) }}
                </option>
            @endforeach
        </select>

        <select name="subject_id" id="filter_status" data-base-url="{{ route('students.index') }}"
            class="p-2 bg-slate-700 text-gray-100 outline-none rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 h-[42px]">
            <option value="">Select Status</option>
            @foreach ($status as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                    {{ ucwords($s) }}
                </option>
            @endforeach
        </select>
        <a class="h-[42px] w-[42px] rounded-lg shadow-sm text-gray-100 bg-slate-700 flex justify-center items-center"
            href="{{ route('students.index') }}">
            <i class="bi bi-arrow-clockwise"></i>
        </a>
    </div>


    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Reg ID</th>
                    <th class="border border-gray-300 px-4 py-2">Course(s)</th>
                    <th class="border border-gray-300 px-4 py-2">Reg Date</th>
                    <th class="border border-gray-300 px-4 py-2">Status</th>
                </tr>
            </thead>
            @if (count($students) > 0)
                <tbody>
                    @foreach ($students as $index => $student)
                        <tr class="hover:bg-slate-950 transition-colors duration-300">
                            <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-2 capitalize">
                                <a class="hover:text-blue-600" href="{{ route('students.show', $student->slug) }}">
                                    {{ $student->first_name }} {{ $student->last_name }}
                                </a>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $student->reg_id }}</td>

                            <td class="border border-gray-300 px-4 py-2 flex gap-1 justify-start flex-wrap">
                                @foreach ($student->courses as $course)
                                    <span
                                        class="inline-block bg-slate-700 text-slate-100 text-xs px-3 py-1 rounded-full mr-1 mb-1 capitalize">
                                        {{ $course->name }}
                                    </span>
                                    <span
                                        class="inline-block bg-slate-700 text-slate-100 text-xs px-3 py-1 rounded-full mr-1 mb-1">
                                        {{ $course->code }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                {{ $student->created_at->format('M d, Y') }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center capitalize">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium
                                @if ($student->status === 'active') bg-green-200 text-green-800
                                @elseif ($student->status === 'discontinued') bg-yellow-200 text-yellow-800
                                @else bg-gray-200 text-slate-800 @endif">
                                    {{ $student->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <tbody>
                    <td colspan="6" class="border border-gray-300 px-4 py-8 text-center">No students found!
                    </td>
                </tbody>
            @endif
        </table>
    </div>
@endsection

@section('script1')
    <script type="module">
        import
        initFilter
        from '/js/utils/filterModule.js';
        initFilter('filter_course', 'course');
        initFilter('filter_status', 'status');
    </script>
@endsection
