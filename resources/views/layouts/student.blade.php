<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Welcome To W3S-C')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.tiny.cloud/1/14elrc4bfiukjypfvbkt44w1228irvuaiqzag73aoa8wi920/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">
    <div class="flex h-screen overflow-y-auto">
        <aside
            class="fixed top-0 left-0 bottom-0 md:static z-50 min-w-72 bg-gradient-to-b from-blue-800 to-blue-900 text-white p-5 flex flex-col justify-between transition-transform duration-300 ease-out -translate-x-full md:transform-none">
            <div>
                <h2 class="text-2xl font-bold mb-5">Student Panel</h2>
                <nav>
                    <ul class="space-y-3">
                        <li><a href="{{ route('student.dashboard') }}"
                                class="block p-2 bg-blue-800 rounded transition-colors">Dashboard</a></li>
                        <li><a href="#" class="block p-2 hover:bg-blue-700 rounded transition-colors">Courses</a>
                        </li>
                        <li><a href="#" class="block p-2 hover:bg-blue-700 rounded transition-colors">Projects</a>
                        </li>
                        <li><a href="{{ route('student.courseAndPayments') }}"
                                class="block p-2 hover:bg-blue-700 rounded transition-colors">Course &
                                Payments</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <a href="{{ route('logout') }}"
                class="bg-red-600 hover:bg-red-500 transition-colors flex justify-center text-white p-2 rounded mt-4">
                Logout
            </a>
        </aside>
        <div class="flex-1 flex flex-col h-screen overflow-y-auto">
            <header class="bg-white shadow py-4 px-8 flex justify-end items-center sticky top-0">
                <div>
                    <p class="text-blue-700 uppercase">
                        @php
                            $name = 'user';
                            if (Auth::guard('students')->check()) {
                                $name =
                                    Auth::guard('students')->user()->first_name .
                                    ' ' .
                                    Auth::guard('students')->user()->last_name;
                            }
                        @endphp
                        <a href="{{ route('student.profile') }}">
                            {{ $name }}
                        </a>
                    </p>
                </div>
                <div class="md:hidden ms-10">
                    <button id="sidebarToggle" class="text-blue-700 p-2">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </header>

            @yield('main')
        </div>
    </div>

    <script>
        if (document.getElementById('studyChart')) {
            const ctx = document.getElementById('studyChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Hours Studied',
                        data: [2, 3, 4, 3, 5, 6, 2],
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
        document.getElementById('sidebarToggle')?.addEventListener('click', (e) => {
            e.stopPropagation();
            const sidebar = document.querySelector('aside');
            sidebar?.classList.toggle('-translate-x-full');
        });

        window.addEventListener("resize", () => {
            document.querySelector('aside')?.classList.add('-translate-x-full');
        })

        document.addEventListener("click", (e) => {
            e.stopPropagation()
            if (!e.target.closest('aside')) {
                document.querySelector('aside')?.classList.add('-translate-x-full');
            }
        });
    </script>
</body>

</html>
