@extends('layouts.admin')

@section('main')
    <h2 class="text-lg font-bold mb-2">
        Add New Student</h2>

    <x-flash-message />

    <form class="flex flex-col gap-6 p-4 mb-8" action="{{ route('students.store') }}" method="POST">
        @csrf

        <!-- Personal Information -->
        <div class="grid grid-cols-[1fr_1fr_0.5fr] gap-6">
            <div>
                <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name"
                    class="w-full p-2 bg-slate-700 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('first_name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name (optional)"
                    class="w-full p-2 bg-slate-700 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('last_name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="relative">
                <span class="text-sm absolute -top-5 text-gray-400">*DOB</span>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                    class="w-full p-2 bg-slate-700 text-slate-200 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('date_of_birth')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Contact & Gender -->
        <div class="grid grid-cols-3 gap-6">
            <div>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                    class="w-full p-2 bg-slate-700 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <input type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone Number"
                    class="w-full p-2 bg-slate-700 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('phone_number')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <select name="gender"
                    class="w-full p-2 bg-slate-700 text-slate-200 rounded-lg outline-none focus:ring focus:ring-blue-500">
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('gender')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Address -->
        <div class="grid grid-cols-4 gap-6">
            <div><input type="text" name="address" value="{{ old('address') }}" placeholder="Address"
                    class="w-full p-2 bg-slate-700 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('address')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div><input type="text" name="city" value="{{ old('city') }}" placeholder="City"
                    class="w-full p-2 bg-slate-700 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('city')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div><input type="text" name="state" value="{{ old('state') }}" placeholder="State"
                    class="w-full p-2 bg-slate-700 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('state')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div><input type="text" name="zip_code" value="{{ old('zip_code') }}" placeholder="Zip Code"
                    class="w-full p-2 bg-slate-700 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('zip_code')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Course Selection -->
        <div>
            <select name="course_id"
                class="w-full p-2 bg-slate-700 text-slate-200 rounded-lg outline-none focus:ring focus:ring-blue-500">
                <option value="">Select Course</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                        {{ ucwords($course->name) }}
                    </option>
                @endforeach
            </select>
            @error('course_id')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Pricing (with enrolment fee) -->
        <div class="grid grid-cols-5 gap-6">
            <div>
                <input type="text" name="base_price" id="base_price" placeholder="Base Price"
                    class="w-full p-2 bg-slate-800 text-slate-300 rounded-lg outline-none" readonly>
            </div>
            <div>
                <input type="number" name="sold_price" id="sold_price" value="{{ old('sold_price') }}"
                    placeholder="Sold Price"
                    class="w-full p-2 bg-slate-700 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('sold_price')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <input type="number" name="discount" id="discount" value="{{ old('discount') }}" placeholder="Discount %"
                    class="w-full p-2 bg-slate-700 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('discount')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <input type="number" name="enrolment_fee" id="enrolment_fee" value="{{ old('enrolment_fee', '') }}"
                    placeholder="Enrolment Fee"
                    class="w-full p-2 bg-slate-700 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('enrolment_fee')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <select name="payment_mode" id="payment_mode"
                    class="w-full p-2 bg-slate-700 text-slate-200 rounded-lg outline-none focus:ring focus:ring-blue-500">
                    <option value="full" {{ old('payment_mode') == 'full' ? 'selected' : '' }}>Full Payment</option>
                    <option value="emi" {{ old('payment_mode') == 'emi' ? 'selected' : '' }}>EMI</option>
                </select>
            </div>
        </div>

        <!-- EMI Fields -->
        <div id="emi_fields" class="grid grid-cols-3 gap-6 mt-4 hidden">
            <div>
                <input type="number" name="emi_months" id="emi_duration" value="{{ old('emi_months') }}"
                    placeholder="EMI Months"
                    class="w-full p-2 bg-slate-700 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('emi_months')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <input type="number" name="emi_amount" id="emi_per_month" value="{{ old('emi_amount') }}"
                    placeholder="EMI Amount"
                    class="w-full p-2 bg-slate-700 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('emi_amount')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <input type="date" name="emi_start_date" value="{{ old('emi_start_date') }}"
                    class="w-full p-2 bg-slate-700 text-slate-200 rounded-lg outline-none focus:ring focus:ring-blue-500">
                @error('emi_start_date')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Submit -->
        <div class="text-right">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Save
                Student</button>
        </div>
    </form>
@endsection

@section('script1')
    <script>
        const courseDropdown = document.querySelector('select[name="course_id"]');
        const basePriceField = document.getElementById('base_price');
        const soldPriceField = document.getElementById('sold_price');
        const discountField = document.getElementById('discount');
        const enrolmentFeeField = document.getElementById('enrolment_fee');
        const paymentMode = document.getElementById('payment_mode');
        const emiFields = document.getElementById('emi_fields');
        const emiDurationField = document.getElementById('emi_duration');
        const emiPerMonthField = document.getElementById('emi_per_month');

        const coursePrices = @json($courses->pluck('base_price', 'id'));

        function updateBasePrice() {
            const courseId = courseDropdown.value;
            const basePrice = coursePrices[courseId] || 0;
            basePriceField.value = basePrice;
            calculatePriceDetails();
        }

        function calculatePriceDetails() {
            const basePrice = parseFloat(basePriceField.value) || 0;
            const discount = parseFloat(discountField.value) || 0;
            const enrolmentFee = parseFloat(enrolmentFeeField.value) || 0;
            const emiDuration = parseInt(emiDurationField.value) || 0;

            const discountAmount = (discount / 100) * basePrice;
            const soldPrice = basePrice - discountAmount;
            soldPriceField.value = soldPrice.toFixed(2);

            if (paymentMode.value === 'emi' && emiDuration > 0) {
                const emiBase = soldPrice - enrolmentFee;
                emiPerMonthField.value = emiBase > 0 ? (emiBase / emiDuration).toFixed(2) : 0;
            } else {
                emiPerMonthField.value = '';
            }
        }

        function toggleEmiFields() {
            emiFields.classList.toggle('hidden', paymentMode.value !== 'emi');
            calculatePriceDetails();
        }

        courseDropdown.addEventListener('change', updateBasePrice);
        discountField.addEventListener('input', calculatePriceDetails);
        enrolmentFeeField.addEventListener('input', calculatePriceDetails);
        emiDurationField.addEventListener('input', calculatePriceDetails);
        paymentMode.addEventListener('change', toggleEmiFields);

        document.addEventListener('DOMContentLoaded', () => {
            updateBasePrice();
            toggleEmiFields();
        });
    </script>
@endsection
