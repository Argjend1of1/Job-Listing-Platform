<x-layout>
    <x-page-heading>Edit Job Listing</x-page-heading>

    <div id="editJobFormContainer" class="max-w-2xl mx-auto space-y-6">
        <form id="editJobForm" action="/dashboard/edit/{{$job->id}}" class="space-y-4">
            <x-forms.input label="Title" name="title" value="{{$job->title}}"/>

            <x-forms.select label="Schedule" name="schedule" value="{{$job->schedule}}">
                <option>Part Time</option>
                <option>Full Time</option>
            </x-forms.select>

            <x-forms.rich-text
                name="about"
                value="{!! $job->about !!}"
                label="About the Job"
                placeholder="Provide job description and list requirements..."
            />

            <x-forms.input label="Salary" name="salary" value="{{$job->salary}}"/>
            <p class="text-red-500 font-semibold" id="responseMessage"></p>

            <div class="mt-7 flex justify-between">
                <button type="submit" class="inline-block px-6 py-2 border-2 border-gray-700 text-white hover:bg-gray-700 transition rounded-full cursor-pointer">Update Job</button>
                <button id="deleteListing" class="border-2 border-red-800 transition rounded-full py-2 px-6 font-bold ml-3 hover:bg-red-800 cursor-pointer focus:bg-red-900">Delete Listing</button>
            </div>
        </form>
    </div>

    @vite(['resources/js/dashboard/modify.js'])
</x-layout>
