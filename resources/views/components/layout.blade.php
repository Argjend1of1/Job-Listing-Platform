<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF token for JavaScript -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Pixel Positions</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="bg-black text-white mb-25 font-hanken-grotesk">
<div class="px-10">
    <nav class="flex justify-between items-center py-5 border-b border-white/10">
        <div>
            <a href="/">
                <img src="" alt="logo"/>
            </a>
        </div>

        <div class="space-x-6 font-bold flex items-center">
            <a href="/jobs" class="hover:underline">Listings</a>
            <a href="/companies" class="hover:underline">Companies</a>

            <div class="relative group inline-block">
                <a href="#" class="hover:underline inline-block">Categories</a>
                <div
                    class="absolute left-0 top-full opacity-0 invisible group-hover:opacity-100 group-hover:visible
    bg-black text-white shadow-lg rounded-md mt-2 z-10 w-max
    transition-opacity transition-transform duration-300 delay-100 ease-in-out transform group-hover:
    -translate-x-40"
                >
                    <div class="grid grid-cols-2 sm:grid-cols-2 gap-3">
                        @foreach($navbarCategories as $category)
                            <a
                                href="/categories/{{$category->name}}"
                                class="text-xs block px-4 py-2 hover:bg-gray-800 rounded whitespace-nowrap transition-colors duration-150"
                            >
                                {{$category->name}}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="space-x-5 flex flex-row items-center hidden" id="sessionLinks"></div>

        <div class="space-x-6 font-bold hidden" id="guestLinks">
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        </div>
    </nav>

    <main class="mt-8 max-w-[986px] mx-auto">
        {{ $slot }}
    </main>
</div>

@vite([
    'resources/js/session.js',
//    'resources/js/dashboard/index.js'
])
{{--@stack('scripts')--}}
</body>
</html>


