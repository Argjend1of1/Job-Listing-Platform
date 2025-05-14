<x-layout>
{{--    <x-page-heading>Log In</x-page-heading>--}}


    <x-forms.form method="POST" action="/api/login" id="loginForm">
        <x-forms.input label="Email" name="email"/>
        <x-forms.input type="password" label="Password" name="password"/>

        <p class="text-red-500" id="responseMessage"></p>

        <x-forms.button type="submit">Log In</x-forms.button>
    </x-forms.form>

    @vite(['resources/js/auth/login.js'])
</x-layout>
