<x-layout>
    <x-page-heading>Applicants for {{$job->title}} Job</x-page-heading>

    <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 mb-2">
        @if($applications->first() !== null)
            @foreach($applications as $application)
                <x-applicant-card :$application/>
            @endforeach
        @else
            <p class="text-gray-500 font-semibold">No applicants yet. Please check later.</p>
        @endif
    </div>

    {{--    shows the previous/next buttons--}}
    <div class="mt-5">
        {{$applications->links()}}
    </div>
</x-layout>
