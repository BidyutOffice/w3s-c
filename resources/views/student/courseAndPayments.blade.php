@extends('layouts.student')

@section('title', 'My Courses & Payments')

@section('main')
    <div class="rounded-lg py-6 md:px-6 px-3">
        <h2 class="text-xl font-semibold mb-6">My Courses & Payment Information</h2>

        @forelse($student->studentCourses as $sc)
            @php
                $pivot = $sc;
                $paidAmount = $pivot->enrolment_fee ?? 0;
                if ($sc->payments->count()) {
                    $paidAmount += $sc->payments->sum('amount');
                }
                $due = $pivot->sold_price - $paidAmount;
                $emiTotal = $pivot->emi_months * $pivot->emi_amount;
            @endphp

            <!-- 🔹 Course Block -->
            <div class="mb-10 pb-6 border-b border-gray-300">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800">{{ $sc->course->name }} <span
                            class="text-sm font-normal text-gray-500">({{ $sc->course->code }})</span></h3>
                    <p class="text-sm text-gray-600">Registration ID: <span class="">{{ $student->reg_id }}</span>
                    </p>
                </div>

                <!-- 💳 Payment Summary -->
                <div class="bg-slate-50 rounded-xl p-5 shadow mb-6">
                    <h4 class="text-md font-semibold mb-4 text-slate-800 border-b pb-2">Payment Summary</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div><label class="font-semibold">Sold Price:</label> ₹{{ number_format($pivot->sold_price, 2) }}
                        </div>
                        <div><label class="font-semibold">Discount:</label> {{ $pivot->discount }}%</div>
                        <div><label class="font-semibold">Enrolment Fee:</label>
                            ₹{{ number_format($pivot->enrolment_fee, 2) }}</div>
                        <div><label class="font-semibold">Payment Mode:</label> <span
                                class="uppercase">{{ ucfirst($pivot->payment_mode) }}</span></div>
                        <div><label class="font-semibold">Total Paid:</label> ₹{{ number_format($paidAmount, 2) }}</div>
                        @if ($due <= 0)
                            <div class="text-green-500 font-semibold">✅ Fully Paid</div>
                        @else
                            <div><label class="font-semibold">Remaining Due:</label> ₹{{ number_format($due, 2) }}</div>
                        @endif
                    </div>
                </div>

                @if ($pivot->payment_mode === 'emi')
                    <!-- 🧾 EMI Details -->
                    <div class="bg-blue-50 rounded-xl p-5 shadow mb-6">
                        <h5 class="text-md font-semibold mb-3 text-blue-700">EMI Plan Details</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-900">
                            <div><label class="font-semibold">EMI Months:</label> {{ $pivot->emi_months }}</div>
                            <div><label class="font-semibold">EMI Amount:</label>
                                ₹{{ number_format($pivot->emi_amount, 2) }}</div>
                            <div><label class="font-semibold">EMI Start Date:</label>
                                {{ \Carbon\Carbon::parse($pivot->emi_start_date)->format('M d, Y') }}</div>
                            <div>
                                <label class="font-semibold">Total EMI Payable:</label> ₹{{ number_format($emiTotal, 2) }}
                                <p class="text-xs text-slate-400">(EMI Amount × Months)</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- 📜 Payment History -->
                <div class="bg-white rounded-xl p-5 shadow border mb-6">
                    <h4 class="text-md font-semibold mb-3 text-slate-800">Payment History</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border">
                            <thead class="bg-slate-100">
                                <tr>
                                    <th class="px-3 py-2 text-left">Amount</th>
                                    <th class="px-3 py-2 text-left">Method</th>
                                    <th class="px-3 py-2 text-left">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sc->payments as $payment)
                                    <tr class="border-t">
                                        <td class="px-3 py-2 text-green-600 font-medium">
                                            ₹{{ number_format($payment->amount, 2) }}
                                        </td>
                                        <td class="px-3 py-2">{{ ucfirst($payment->method) }}</td>
                                        <td class="px-3 py-2">
                                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-gray-500 px-3 py-2">No payments found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 📄 PDF Download -->
                <div class="flex justify-end mt-4">
                    <a href="{{ route('student.payments.pdf') }}" target="_blank"
                        class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded print:hidden">
                        Download Summary as PDF
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-500">You are not enrolled in any courses yet.</p>
        @endforelse
    </div>
@endsection
