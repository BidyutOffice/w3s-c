<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Payment Details - {{ $student->first_name }} {{ $student->last_name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 20px;
        }

        h2,
        h3 {
            margin-bottom: 10px;
            color: #222;
        }

        .section {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .text-right {
            text-align: right;
        }

        .text-green {
            color: green;
        }

        .text-red {
            color: red;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .small {
            font-size: 12px;
            color: #555;
        }
    </style>
</head>

<body>
    <h2>Student Payment Report</h2>

    <div class="section">
        <h3>📄 Student Information</h3>
        <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
        <p><strong>Email:</strong> {{ $student->email }}</p>
        <p><strong>Registration ID:</strong> {{ $student->reg_id ?? 'N/A' }}</p>
    </div>

    @php
        $pivot = $student->courses->first()?->pivot;
        $studentCourse = $student->studentCourses->first();
        $payments = $studentCourse?->payments ?? collect();
        $paidAmount = ($pivot->enrolment_fee ?? 0) + $payments->sum('amount');
        $due = $pivot ? $pivot->sold_price - $paidAmount : 0;
    @endphp

    <div class="section">
        <h3>Payment Summary</h3>
        <table>
            <tr>
                <th>Sold Price</th>
                <td>₹{{ number_format($pivot->sold_price ?? 0, 2) }}</td>
            </tr>
            <tr>
                <th>Discount</th>
                <td>{{ $pivot->discount ?? 0 }}%</td>
            </tr>
            <tr>
                <th>Enrolment Fee</th>
                <td>₹{{ number_format($pivot->enrolment_fee ?? 0, 2) }}</td>
            </tr>
            <tr>
                <th>Total Paid</th>
                <td>₹{{ number_format($paidAmount, 2) }}</td>
            </tr>
            <tr>
                <th>Remaining Due</th>
                <td class="{{ $due <= 0 ? 'text-green' : 'text-red' }}">
                    {{ $due <= 0 ? 'Complete Paid' : '₹' . number_format($due, 2) }}
                </td>
            </tr>
            <tr>
                <th>Payment Mode</th>
                <td>{{ ucfirst($pivot->payment_mode ?? 'N/A') }}</td>
            </tr>
        </table>
    </div>

    @if ($pivot && $pivot->payment_mode === 'emi')
        <div class="section">
            <h3>EMI Plan</h3>
            <table>
                <tr>
                    <th>EMI Months</th>
                    <td>{{ $pivot->emi_months }}</td>
                </tr>
                <tr>
                    <th>EMI Amount</th>
                    <td>₹{{ number_format($pivot->emi_amount, 2) }}</td>
                </tr>
                <tr>
                    <th>Start Date</th>
                    <td>{{ \Carbon\Carbon::parse($pivot->emi_start_date)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Total EMI Payable</th>
                    <td>₹{{ number_format($pivot->emi_months * $pivot->emi_amount, 2) }}</td>
                </tr>
            </table>
        </div>
    @endif

    @if ($payments->count())
        <div class="section">
            <h3>📆 Payment History</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Added By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $index => $pay)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>₹{{ number_format($pay->amount, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($pay->payment_date)->format('d M Y') }}</td>
                            <td>{{ ucfirst($pay->method) }}</td>
                            <td>{{ $pay->addedBy->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-red">No payment records available.</p>
    @endif

    <p class="small">Generated on {{ now()->format('d M Y, h:i A') }}</p>
</body>

</html>
