<x-layout>
    <x-page-heading>{{$employer->name}}'s Listed Jobs</x-page-heading>

    @if($jobs)
        @foreach($jobs as $job)
            <div class="mt-5">
                <x-job-card-wide :$job/>
            </div>
        @endforeach
    @else
        <p class="text-gray-400 font-semibold mt-3">This company has no jobs listed currently.</p>
    @endif
</x-layout>
