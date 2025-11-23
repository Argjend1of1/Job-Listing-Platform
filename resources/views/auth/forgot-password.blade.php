<!-- resources/views/auth/forgot-password.blade.php -->

    <div class="max-w-md mx-auto mt-10">

        <h1 class="text-2xl font-bold mb-4">Forgot your password?</h1>
        <p class="mb-6 text-gray-700">Enter your email and we will send you a password reset link.</p>

        <!-- Status Message -->
        @if (session('status'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('status') }}
            </div>
        @endif

        <!-- Errors -->
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium" for="email">Email</label>
                <input
                    class="w-full border rounded px-3 py-2"
                    type="email"
                    name="email"
                    id="email"
                    required
                    autofocus
                    value="{{ old('email') }}"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700"
            >
                Send Password Reset Link
            </button>
        </form>
    </div>
