@extends('layouts.admin')
@section('main')
    <!-- Label for the Form -->
    <h2 class="text-lg font-bold mb-2">Add New Content</h2>

    <!-- Success and Error Messages -->
    <x-flash-message />

    <form method="post" enctype="multipart/form-data" class="text-gray-800 py-3 gap-4 bg-transparent rounded-lg mb-8">
        <!-- Blog Title -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-100" for="title">Title</label>
            <input class="w-full h-[42px] p-2 border border-gray-300 outline-none rounded-lg focus:ring focus:ring-blue-500"
                type="text" id="title" name="title" placeholder="Enter blog title" />
        </div>

        <div class="flex gap-6 mb-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-100" for="title">Subjects</label>
                <select name="subject_id" id="filter_subject"
                    class="w-full h-[42px]  border border-gray-300 text-gray-800 outline-none rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Subjects</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->slug }}" {{ request('sub') == $subject->slug ? 'selected' : '' }}>
                            {{ ucwords($subject->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Topics Dropdown -->
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-100" for="topics">Topics</label>
                <select
                    class="w-full h-[42px] p-2 border border-gray-300 outline-none rounded-lg focus:ring focus:ring-blue-500"
                    name="topic_id" id="topics">
                    <option value="">Select a Topic</option>
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}" {{ request('sub') == $topic->slug ? 'selected' : '' }}>
                            {{ ucwords($topic->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Blog Content -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-100" for="content">Content</label>
            <textarea
                class="rich-text-editor mt-1 block w-full rounded-b-md outline-none p-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                rows="20" name="content" id="content" placeholder='Write your blog content here...'></textarea>
        </div>

        <!-- Submit Button -->
        <div class="text-center mt-2">
            <button name="blogs" type="submit"
                class="inline-flex justify-center text-lg px-5 py-2 border border-transparent font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                Submit
            </button>
        </div>
    </form>

    <script>
        tinymce.init({
            selector: 'textarea#content',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>

    <script>
        const filterSubject = document.getElementById('filter_subject');
        filterSubject.addEventListener("change", () => {
            const selectedValue = filterSubject.value;
            const baseUrl = "{{ route('contents.create') }}";
            const newUrl = selectedValue ? `${baseUrl}?sub=${selectedValue}` : baseUrl;
            window.location.href = newUrl;
        });
    </script>
@endsection
