@extends('layouts.auth')
@section('title', 'W3S-C | Create an Account')

@section('auth-main')
    <main class="w-full h-screen bg-gradient-to-br from-blue-600 to-indigo-800 flex items-center justify-center p-6">
        <div class="w-full max-w-lg bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('register') }}" method="post" class="space-y-6">
                @csrf
                <h2 class="text-3xl font-bold text-center text-indigo-700">Create Account</h2>
                @if (session('success'))
                    <div class="text-sm text-green-500 my-1 capitalize">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="text-sm text-red-500 my-1 capitalize">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input value="{{ old('name') }}" type="text" id="name" name="name"
                            placeholder="Enter your full name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            required>
                        @error('name')
                            <p class="text-sm text-red-500 mt-1 capitalize">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input value="{{ old('email') }}" type="email" id="email" name="email"
                            placeholder="Enter your email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            required>
                        @error('email')
                            <p class="text-sm text-red-500 mt-1 capitalize">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            required>
                        @error('password')
                            <p class="text-sm text-red-500 mt-1 capitalize">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                            Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Confirm your password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            required>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    Register
                </button>

                <!-- Login Link -->
                <p class="text-sm text-center text-gray-600">
                    Already have an account?
                    <a href="#" class="text-indigo-600 hover:underline">Login here</a>
                </p>
            </form>
        </div>
    </main>
@endsection
