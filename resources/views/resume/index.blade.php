<x-layout>
    <x-page-heading>Upload Your Resume</x-page-heading>

    <x-forms.form method="POST" id="uploadResumeForm" action="/api/resume" enctype="multipart/form-data">
        <x-forms.input label="Resume" name="resume" type="file"/>

        <p class="text-red-500" id="responseMessage"></p>

        <x-forms.button>Upload</x-forms.button>

        @vite(['resources/js/resume/index.js'])
    </x-forms.form>
</x-layout>
