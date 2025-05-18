<x-layout>
    <x-page-heading>Jobs Listed for {{$category->name}}</x-page-heading>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($jobs as $job)
            <x-job-card :$job/>
        @endforeach
    </div>

    <div class="mt-5">
        {{$jobs->links()}}
    </div>
</x-layout>
