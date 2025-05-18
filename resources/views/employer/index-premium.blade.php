<x-layout>
    <x-page-heading>
        {{ isset($query) && $query ? "Search Results for \"$query\"" : 'Premium Employers' }}
    </x-page-heading>
    <x-forms.form class="mt-6 mb-10" action="/premiumEmployers">
        <x-forms.input :label="false" name="q" value="{{$query ?? null}}" placeholder="Search For Employer..." />
    </x-forms.form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @if($employers->first() !== null)
            @foreach($employers as $employer)
                <x-employer-card-wide :$employer/>
            @endforeach
        @else
            <p class="text-lg text-gray-500">No premium employer found.</p>
        @endif
    </div>

    <div class="mt-5">
        {{$employers->links()}}
    </div>

    @vite(['resources/js/employer/updatePremium.js'])
</x-layout>
