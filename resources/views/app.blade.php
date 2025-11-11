<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Essential metadata -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Job Listing Platform</title>

    <!-- Scripts -->
    @viteReactRefresh
    @vite('resources/js/app.jsx')
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>
