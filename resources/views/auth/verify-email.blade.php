<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Email Verification</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        @vite('resources/css/app.css')
    </head>

    <body class="bg-gray-100 min-h-screen flex items-center justify-center">

        <div class="w-full max-w-md bg-white shadow-md rounded-lg p-8">

            {{-- Title --}}
            <h1 class="text-2xl font-bold text-gray-800 mb-4">
                Verify Your Email
            </h1>

            {{-- Description --}}
            <p class="text-gray-600 mb-6">
                Before accessing your account, we need to verify your email address.
                <br>
                Please check your inbox for the verification link.
            </p>

            {{-- Success message after resending --}}
            @if (session('message'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif

            {{-- Resend verification link form --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded transition"
                >
                    Resend Verification Email
                </button>
            </form>

        </div>

    </body>

</html>
