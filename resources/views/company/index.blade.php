<x-layout>
    <x-page-heading>Companies</x-page-heading>

    <x-forms.form class="mt-6 mb-10" action="/companies">
        <x-forms.input :label="false" name="q" value="{{$query ?? null}}" placeholder="Search For Company..." />
    </x-forms.form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @if($employers->first() !== null)
            @foreach($employers as $employer)
                <x-employer-card :$employer/>
            @endforeach
        @else
            <p class="text-gray-400 font-semibold mt-3">No company found.</p>
        @endif
    </div>

    <div class="mt-5">
        {{$employers->links()}}
    </div>
</x-layout>
