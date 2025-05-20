<x-layout>
    <x-page-heading>Bookmarks</x-page-heading>

    <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 mb-2">
        @if($jobs->first() !== null)
            @foreach($jobs as $job)
                <div class="min-w-[300px]">
                    <x-bookmarked-job :$job/>
                </div>
            @endforeach
        @else
            <p class="text-gray-400 font-semibold">You have no jobs bookmarked currently.</p>
        @endif
    </div>
</x-layout>
