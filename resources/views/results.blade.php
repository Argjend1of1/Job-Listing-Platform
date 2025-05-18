<x-layout>
    <x-page-heading>Results for '{{$search}}'</x-page-heading>

    <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 ">
        @foreach($jobs as $job)
            <x-job-card :$job/>
        @endforeach
    </div>

    <div class="mt-5">
        {{$jobs->links()}}
    </div>
</x-layout>
