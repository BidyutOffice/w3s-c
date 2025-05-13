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
            <div><strong>Payment Mode:</strong> <span class="uppercase">{{ ucfirst($pivot->payment_mode) }}</span></div>
            <div><strong>Total Paid:</strong> ₹{{ number_format($paidAmount, 2) }}</div>
            @if ($due <= 0)
                <div class="text-green-400"><strong>✅ Complete Paid</strong></div>
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
                        <p class="absolute text-[13px] text-slate-500 -bottom-4">(EMI Amount x Months)</p>
                    </div>
                </div>
            </div>
        @endif
    @else
        <p class="text-red-400">No payment details available.</p>
    @endif
</div>
