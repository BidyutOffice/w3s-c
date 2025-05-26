@extends('layouts.admin')

@section('title', 'Make Payment')

@section('main')
    <h2 class="text-xl font-bold mb-6">Make a Payment</h2>

    <x-flash-message />

    {{-- 🔍 Search Student --}}
    <form id="studentSearchForm" class="mb-6 rounded-xl">
        @csrf
        <h3 class="text-lg font-semibold text-white mb-4">Search Student</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 relative">
            <input type="text" id="regInput" name="reg_id" placeholder="Search by Reg ID"
                class="form-input bg-slate-700 rounded p-2 outline-none focus:ring focus:ring-blue-500">

            <input type="text" id="nameInput" name="name" placeholder="Search by Name"
                class="form-input bg-slate-700 rounded p-2 outline-none focus:ring focus:ring-blue-500">

            <ul id="searchResults"
                class="absolute z-10 bg-slate-700 top-full mt-1 w-full max-h-52 overflow-auto shadow-lg hidden rounded">
            </ul>
        </div>
    </form>

    <div class="grid md:grid-cols-4 gap-6">
        {{-- Left: Student List --}}
        <div class="md:col-span-1 bg-slate-800 p-4 rounded-xl max-h-[70vh] overflow-auto mt-6 shadow-lg">
            <h3 class="text-white text-lg font-semibold mb-4">📋 Student List</h3>
            <ul id="studentList">
                @foreach ($studentsList as $student)
                    <li class="cursor-pointer capitalize px-3 py-2 rounded text-gray-100 hover:bg-slate-700 hover:text-white transition text-sm"
                        onclick='displayStudentForm(@json($student))'>
                        {{ $student['first_name'] }} {{ $student['last_name'] }} ({{ $student['reg_id'] }})
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Right: Payment Form --}}
        <div id="studentInfoContainer" class="md:col-span-3"></div>
    </div>
@endsection

@section('script1')
    <script>
        const regInput = document.getElementById("regInput");
        const nameInput = document.getElementById("nameInput");
        const searchResults = document.getElementById("searchResults");
        const studentInfoContainer = document.getElementById("studentInfoContainer");

        let debounceTimer;
        const debounce = (func, delay = 300) => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(func, delay);
        };

        const createElement = (tag, className = '', text = '') => {
            const el = document.createElement(tag);
            if (className) el.className = className;
            if (text) el.textContent = text;
            return el;
        };

        const fetchStudents = async () => {
            const name = nameInput.value.trim();
            const reg_id = regInput.value.trim();

            if (!name && !reg_id) {
                searchResults.classList.add("hidden");
                searchResults.innerHTML = '';
                return;
            }

            const response = await fetch("{{ route('payments.searchStudent') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    name,
                    reg_id
                })
            });

            const data = await response.json();

            if (response.ok && data.students.length > 0) {
                searchResults.innerHTML = '';
                searchResults.classList.remove("hidden");

                data.students.forEach(student => {
                    const li = createElement("li",
                        "px-4 py-2 cursor-pointer text-lg capitalize hover:bg-blue-500 hover:text-white",
                        `${student.first_name} ${student.last_name} (${student.reg_id})`);
                    li.onclick = () => displayStudentForm(student);
                    searchResults.appendChild(li);
                });
            } else {
                searchResults.classList.add("hidden");
                searchResults.innerHTML = '';
            }
        };

        const displayStudentForm = (student) => {
            searchResults.classList.add("hidden");
            searchResults.innerHTML = '';

            const courseOptions = student.courses.map(
                course => `<option value="${course.id}">${course.name}</option>`
            ).join('');

            studentInfoContainer.innerHTML = `
        <div class="bg-slate-800 p-6 rounded-xl mt-6 shadow-xl animate-fade-in">
            <h3 class="text-lg font-semibold text-white mb-4">👤 Student Info</h3>
            <p class="text-gray-200 mb-1 capitalize"><strong>Name:</strong> ${student.first_name} ${student.last_name}</p>
            <p class="text-gray-200 mb-4"><strong>Reg ID:</strong> ${student.reg_id}</p>

            <form action="{{ route('payments.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="student_id" value="${student.id}">

                <div>
                    <label class="block text-white mb-1">Select Course:</label>
                    <select name="course_id" required class="form-select w-full p-2 rounded bg-slate-700 text-white outline-none focus:ring focus:ring-blue-500">
                        <option disabled selected>Select a course</option>
                        ${courseOptions}
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="number" step="0.01" name="amount" placeholder="Enter Amount" class="form-input p-2 rounded bg-slate-700 text-white outline-none focus:ring focus:ring-blue-500" required>

                    <input type="date" name="payment_date" value="{{ now()->format('Y-m-d') }}" class="form-input p-2 rounded bg-slate-700 text-white outline-none focus:ring focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-white mt-2 mb-1">Payment Method:</label>
                    <select name="method" class="form-select w-full p-2 rounded bg-slate-700 text-white outline-none focus:ring focus:ring-blue-500" required>
                        <option disabled selected>Select method</option>
                        <option value="cash">Cash</option>
                        <option value="upi">UPI</option>
                        <option value="card">Card</option>
                        <option value="bank">Bank Transfer</option>
                    </select>
                </div>

                <input type="text" name="reference_no" placeholder="Reference No (optional)" class="form-input w-full p-2 rounded mt-2 bg-slate-700 text-white outline-none focus:ring focus:ring-blue-500">

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    Submit Payment
                </button>
            </form>
        </div>`;
        };

        [nameInput, regInput].forEach(input => {
            input.addEventListener("input", () => debounce(fetchStudents));
        });

        document.addEventListener('click', (e) => {
            if (!searchResults.contains(e.target) && !nameInput.contains(e.target) && !regInput.contains(e
                    .target)) {
                searchResults.classList.add("hidden");
            }
        });
    </script>
@endsection
