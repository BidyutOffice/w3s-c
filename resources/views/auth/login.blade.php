@extends('layouts.auth')
@section('title', 'W3S-C | Access Your Account')

@section('auth-main')
    <main
        class="w-full h-screen bg-gradient-to-br from-green-700 to-green-900 flex flex-col items-center justify-center p-6">
        <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
            <form action="{{ route('login') }}" method="post" class="space-y-6">
                @csrf
                <p class="text-center text-3xl font-bold text-green-800">Login Here</p>
                <x-flash-message />

                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input value="{{ old('email') }}" type="email" id="email" name="email"
                        placeholder="Enter your email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none"
                        required>

                    @error('email')
                        <p class="text-sm text-red-500 mt-1 capitalize">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none"
                        required>
                    @error('password')
                        <p class="text-sm text-red-500 mt-1 capitalize">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select id="role" name="role"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none"
                        required>
                        <option value="student">Student</option>
                        <option value="admin">Admin</option>
                    </select>
                    @error('role')
                        <p class="text-sm text-red-500 mt-1 capitalize">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full py-2 text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    Login
                </button>
                <p class="text-sm text-center text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register.page') }}" class="text-green-700 hover:underline">Sign up</a>
                </p>
            </form>
        </div>
    </main>
@endsection
