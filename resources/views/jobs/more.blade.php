<x-layout>
    <div class="space-y-10">
        <section class="text-center pt-6">
            <x-page-heading>
                {{ isset($query) && $query ? "Search Results for \"$query\"" : 'Search Your Next Job' }}
            </x-page-heading>

            <x-forms.form class="mt-6" action="/jobs">
                <x-forms.input :label="false" name="q" placeholder="Web Developer..." />
            </x-forms.form>
        </section>

        <section class="pt-10">
            <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 ">
                @foreach($jobs as $job)
                    <x-job-card :$job/>
                @endforeach
            </div>
        </section>
    </div>

    <div class="mt-5">
        {{$jobs->links()}}
    </div>
</x-layout>
