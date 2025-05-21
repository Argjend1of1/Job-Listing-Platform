<x-layout>
    <x-page-heading>Confirm Reset</x-page-heading>
    <x-forms.form method="POST" id="resetPasswordForm">
        <input type="hidden" name="token" id="resetToken">
        <input type="hidden" name="email" id="resetEmail">

        <x-forms.input label="Password" name="password" type="password"/>
        <x-forms.input label="Confirm Password" name="password_confirmation" type="password"/>

        <div id="responseMessage" class="text-green-400 mt-2"></div>

        <x-forms.button type="submit">Reset Password</x-forms.button>
    </x-forms.form>

    @vite('resources/js/password/store.js')
</x-layout>


