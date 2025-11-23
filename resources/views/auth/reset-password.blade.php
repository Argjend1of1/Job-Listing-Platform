<!-- resources/views/auth/reset-password.blade.php -->

    <div class="max-w-md mx-auto mt-10">

        <h1 class="text-2xl font-bold mb-4">Reset Your Password</h1>

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

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Hidden token -->
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label class="block mb-1 font-medium" for="email">Email</label>
                <input
                    class="w-full border rounded px-3 py-2"
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium" for="password">New Password</label>
                <input
                    class="w-full border rounded px-3 py-2"
                    type="password"
                    name="password"
                    id="password"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium" for="password_confirmation">
                    Confirm New Password
                </label>
                <input
                    class="w-full border rounded px-3 py-2"
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    required
                >
            </div>

            <button
                type="submit"
                class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700"
            >
                Reset Password
            </button>
        </form>
    </div>
