<x-layout>
    <x-page-heading>Register</x-page-heading>

    <x-forms.form method="POST" id="registerForm" action="/api/register" enctype="multipart/form-data">
        <x-forms.input label="Your Name" name="name"/>
        <x-forms.input label="Email" name="email"/>
        <x-forms.input type="password" label="Password" name="password"/>
        <x-forms.input type="password" label="Password Confirmation" name="password_confirmation"/>
        <x-forms.input label="Profile Image" name="logo" type="file"/>
        <x-forms.select class="text-white p-2" label="Category" name="category">
            <x-forms.option value="">-Select a Category-</x-forms.option>
            @foreach($categories as $category)
                <x-forms.option value="{{$category->name}}">{{$category->name}}</x-forms.option>
            @endforeach
        </x-forms.select>

        <x-forms.divider/>

        <div class="mb-4">
            <label for="is_company" class="inline-flex items-center space-x-2 text-sm font-medium text-gray-700">
                <input type="checkbox" id="is_company" name="is_company" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <span>I'm registering as a company</span>
            </label>
        </div>

        <!-- Company Name Input - Initially hidden, shown when checkbox is selected via JS -->
        <div id="companyNameInput" class="hidden transition-opacity duration-300">
            <x-forms.input label="Company Name" name="employer" />
        </div>

        <p id="responseMessage" class="mt-2"></p>

        <x-forms.button>Create Account</x-forms.button>

        @vite(['resources/js/auth/register.js'])
    </x-forms.form>

</x-layout>
