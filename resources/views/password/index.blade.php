<x-layout>
    <x-page-heading>Reset Your Password</x-page-heading>
    <x-forms.form method="POST" id="forgotPasswordForm">
        <x-forms.input label="Email" name="email"/>
        <p class="text-green-600" id="responseMessage"></p>

        <x-forms.button type="submit">Send Reset Link</x-forms.button>

    </x-forms.form>

    @vite('resources/js/password/index.js')
</x-layout>


