@extends('layouts.admin')

@section('title', 'Manage Payments')

@section('main')

    <h2 class="text-xl font-semibold mb-4">💰 Manage Payments</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Student</th>
                    <th class="px-4 py-2 text-left">Reg ID</th>
                    <th class="px-4 py-2 text-left">Course</th>
                    <th class="px-4 py-2 text-left">Amount</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Mode</th>
                    <th class="px-4 py-2 text-left">Added By</th>
                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($payments as $payment)
                    <tr>
                        <td class="px-4 py-2">
                            {{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}</td>
                        <td class="px-4 py-2 capitalize">
                            {{ $payment->studentCourse->student->first_name }}
                            {{ $payment->studentCourse->student->last_name }}
                        </td>
                        <td class="px-4 py-2 font-mono text-xs">
                            {{ $payment->studentCourse->student->reg_id }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $payment->studentCourse->course->name }}
                        </td>
                        <td class="px-4 py-2 text-green-600 font-semibold">
                            ₹{{ number_format($payment->amount, 2) }}
                        </td>
                        <td class="px-4 py-2">
                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-2">
                            {{ ucfirst($payment->method) }}
                        </td>
                        <td class="px-4 py-2 text-blue-600">
                            {{ $payment->addedBy->name ?? 'System' }}
                        </td>
                        <td class="px-4 py-2">
                            <a href="#" class="text-indigo-600 hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-4 text-center text-gray-500">No payments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $payments->links() }}
    </div>

@endsection
