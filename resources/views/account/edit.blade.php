<x-layout>
    <x-page-heading>Edit Account</x-page-heading>

    <div id="editAccount" class="max-w-2xl mx-auto space-y-6">
        <h2 class="text-2xl font-bold text-white mb-6">Account Information</h2>
        <div class="space-y-4">
            <div>
                <p class="text-sm text-white font-semibold">Name:</p>
                <p class="text-gray-400 text-base">${user.name}</p>
            </div>

            <div>
                <p class="text-sm text-white font-semibold">Email:</p>
                <p class="text-gray-400 text-base">${user.email}</p>
            </div>
            <div class="pt-6">
                <a href="/account/edit"
                   class="inline-block px-6 py-2 border-2 border-gray-700 text-white hover:bg-gray-700 transition rounded-full focus:bg-gray-800">
                    Edit Account
                </a>
            </div>
    </div>
    @vite(['resources/js/account/edit.js', 'resources/js/account/modify.js'])

</x-layout>
