<x-layout>
    <div class="space-y-10">
        <h1 class="font-bold text-4xl text-center">Let's Find Your Next Job</h1>

        <section class="pt-3">
            <x-section-heading>Top Jobs</x-section-heading>

            <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 mb-2">
                @if($topJobs)
                    @foreach($topJobs as $job)
                        <div class="min-w-[300px]">
                            <x-job-card :$job/>
                        </div>
                    @endforeach
                @endif
            </div>
{{--            to be implemented for all the top jobs--}}
            <a href="/jobs/top" class="text-gray-400 hover:text-white flex justify-end">See more</a>

        </section>

        <section>
            <x-section-heading>Most Searched Tags</x-section-heading>

            <div class="mt-6 space-x-1">
                @foreach($tags as $tag)
                    <x-tag :$tag class="text=[20px] px-3.5 py-1.5"/>
                @endforeach
            </div>

        </section>

        <section>
            <x-section-heading>More Jobs</x-section-heading>
            <div class="flex overflow-x-auto space-x-6 px-4 py-2 scrollbar-custom mb-2">
                @if($otherJobs)
                    @foreach($otherJobs as $job)
                        <div class="min-w-[300px] flex-shrink-0">
                            <x-job-card :$job/>
                        </div>
                    @endforeach
                @endif
            </div>
{{--            to be implemented for all the other jobs--}}
            <a href="/jobs/more" class="text-gray-400 hover:text-white flex justify-end">See more</a>
        </section>
    </div>
</x-layout>
