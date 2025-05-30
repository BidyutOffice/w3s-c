@extends('layouts.admin')
@section('main')
    <x-flash-message />

    <form action="{{ route('topics.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Topic Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="name">Subject:</label>
            <select name="subject_id" id="subject_id">
                <option value="">Select Subject</option>
                @foreach ($subjects as $sub)
                    <option value="{{ $sub->id }}">{{ ucwords($sub->name) }}</option>
                @endforeach
            </select>
            @error('subject_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Save</button>
    </form>
@endsection
