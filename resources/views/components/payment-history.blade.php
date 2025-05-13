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
                                <td class="py-2 px-3 text-green-600">₹{{ number_format($payment->amount, 2) }}</td>
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
