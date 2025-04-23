<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>welcome to w3s-c</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <main
        class="w-full h-screen bg-gradient-to-br from-green-700 to-green-900 flex flex-col items-center justify-center gap-8 p-4">
        <!-- Main Heading -->
        <h1 class="text-6xl font-bold text-slate-200 text-center">
            Welcome to <span class="text-yellow-500">W3s-C</span>
        </h1>

        <!-- Description -->
        <p class="text-lg text-slate-200 text-center max-w-xl leading-relaxed">
            Your ultimate platform for learning web development and programming. Access comprehensive resources, track
            your progress, and enhance your skills effortlessly.
        </p>

        <!-- Buttons Section -->
        <div class="flex gap-6 mt-4">
            <button
                class="py-2 px-8 bg-transparent border-2 border-yellow-500 text-yellow-500 capitalize text-lg font-medium rounded-sm hover:bg-yellow-500 hover:text-green-900 transition duration-300">
                Visit Home
            </button>
            <a href="{{ route('login.page') }}"
                class="py-2 px-8 bg-yellow-500 text-green-900 capitalize text-lg font-medium rounded-sm hover:bg-yellow-600 transition duration-300">
                Login
            </a>
        </div>
    </main>
</body>

</html>
