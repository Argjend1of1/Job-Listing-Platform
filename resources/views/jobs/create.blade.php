<x-layout>
    <x-page-heading>New Job Listing</x-page-heading>
    <x-forms.form method="POST" action="/api/jobs/create" id="jobForm">
        <x-forms.input label="Title" name="title" placeholder="CEO" />
        <x-forms.input label="Salary" name="salary" placeholder="$90,000 USD" />
        <x-forms.input label="Location" name="location" placeholder="Winter Park, Florida" />

        <x-forms.select label="Schedule" name="schedule">
            <option>Part Time</option>
            <option>Full Time</option>
        </x-forms.select>

        <x-forms.rich-text
            name="about"
            label="About the Job"
            placeholder="Provide job description and list requirements..."
        />

        <x-forms.divider/>

        <x-forms.input label="URL" name="url" placeholder="https://acme.com/jobs/ceo-wanted" />
        <x-forms.input label="Tags (comma separated)" name="tags" placeholder="developer, frontend, backend" />
        <p class="mt-3 mb-3 text-red-500" id="responseMessage"></p>

        <x-forms.button type="submit">Publish</x-forms.button>
    </x-forms.form>

    @vite('resources/js/jobs/store.js')
</x-layout>
