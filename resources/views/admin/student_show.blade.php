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

        <!-- 💰 Payment Details -->
        <div class="bg-slate-800 rounded-xl p-6 shadow">
            <h3 class="text-xl font-semibold text-white mb-4 border-b pb-2 border-slate-600">
                💰 Payment Details
            </h3>
            @php
                $pivot = $student->courses->first()->pivot ?? null;
            @endphp

            @if ($pivot)
                @php
                    $firstCourse = $student->courses->first();
                    $studentCourse = \App\Models\StudentCourse::where('student_id', $student->id)
                        ->where('course_id', $firstCourse->id)
                        ->with('payments')
                        ->first();

                    $paidAmount = $pivot->enrolment_fee ?? 0;

                    if ($studentCourse && $studentCourse->payments->count()) {
                        $paidAmount += $studentCourse->payments->sum('amount');
                    }

                    $due = $pivot->sold_price - $paidAmount;
                    $emiTotal = $pivot->emi_months * $pivot->emi_amount;
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-200">
                    <div><strong>Sold Price:</strong> ₹{{ number_format($pivot->sold_price, 2) }}</div>
                    <div><strong>Discount:</strong> {{ $pivot->discount }}%</div>
                    <div><strong>Enrolment Fee:</strong> ₹{{ number_format($pivot->enrolment_fee, 2) }}</div>
                    <div><strong>Payment Mode:</strong> <span class="uppercase">{{ ucfirst($pivot->payment_mode) }}</span>
                    </div>
                    <div><strong>Total Paid:</strong> ₹{{ number_format($paidAmount, 2) }}</div>
                    @if ($due <= 0)
                        <div class="text-green-400 font-semibold"><strong>✅ Complete Paid</strong></div>
                    @else
                        <div><strong>Remaining Due:</strong> ₹{{ number_format($due, 2) }}</div>
                    @endif
                </div>

                @if ($pivot->payment_mode === 'emi')
                    <!-- 🧾 EMI Breakdown -->
                    <div class="mt-6 rounded-lg p-4 text-gray-100">
                        <h4 class="text-lg font-semibold mb-2">🧾 EMI Plan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><strong>EMI Months:</strong> {{ $pivot->emi_months }}</div>
                            <div><strong>EMI Amount:</strong> ₹{{ number_format($pivot->emi_amount, 2) }}</div>
                            <div><strong>EMI Start Date:</strong>
                                {{ \Carbon\Carbon::parse($pivot->emi_start_date)->format('M d, Y') }}
                            </div>
                            <div class="relative">
                                <strong>Total Payable via EMI:</strong> ₹{{ number_format($emiTotal, 2) }}
                                <p class="absolute text-[13px] text-slate-500 -bottom-4">(EMI Amount × Months)</p>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <p class="text-red-400">No payment details available.</p>
            @endif
        </div>

        <!-- 💳 Payments for each course -->
        <div class="bg-slate-800 rounded-xl p-6 shadow">
            <h3 class="text-xl font-semibold text-white mb-4 border-b pb-2 border-slate-600">💳 Payment History</h3>

            @php
                $hasPayments = false;
            @endphp

            @foreach ($student->courses as $course)
                @php
                    $studentCourse = \App\Models\StudentCourse::where('student_id', $student->id)
                        ->where('course_id', $course->id)
                        ->with('payments')
                        ->first();
                @endphp

                @if ($studentCourse && $studentCourse->payments->count())
                    @php $hasPayments = true; @endphp

                    <div class="mb-6 rounded-lg p-4">
                        <h4 class="text-white text-lg font-bold mb-2">💼 {{ $course->name }} Payments</h4>

                        <table class="w-full text-sm text-left text-gray-200">
                            <thead class="text-xs uppercase text-gray-400 border-b border-slate-600">
                                <tr>
                                    <th class="py-2 px-3">#</th>
                                    <th class="py-2 px-3">Amount</th>
                                    <th class="py-2 px-3">Date</th>
                                    <th class="py-2 px-3">Mode</th>
                                    <th class="py-2 px-3">Reference</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($studentCourse->payments as $index => $payment)
                                    <tr class="border-b border-slate-700">
                                        <td class="py-2 px-3">{{ $index + 1 }}</td>
                                        <td class="py-2 px-3">₹{{ number_format($payment->amount, 2) }}</td>
                                        <td class="py-2 px-3">
                                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                                        <td class="py-2 px-3 uppercase">{{ ucfirst($payment->method) }}</td>
                                        <td class="py-2 px-3">{{ ucfirst($payment->reference_no) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach

            @unless ($hasPayments)
                <p class="text-gray-300">No payments found for any courses.</p>
            @endunless
        </div>

        <!-- 🔙 Back Button -->
        <div class="mt-8">
            <a href="{{ route('students.index') }}"
                class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
                ⬅ Back to List
            </a>
        </div>
    </div>
@endsection
