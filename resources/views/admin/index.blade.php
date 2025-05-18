<x-layout>
    <x-page-heading>
        {{ isset($query) && $query ? "Search Results for \"$query\"" : 'Admins' }}
    </x-page-heading>
    <x-forms.form class="mt-6 mb-10" action="/admins">
        <x-forms.input :label="false" name="q" value="{{$query ?? null}}" placeholder="Search For Admin..." />
    </x-forms.form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @if($admins->first() !== null)
            @foreach($admins as $admin)
                <x-admin-card :$admin/>
            @endforeach
        @else
            <p class="text-lg text-gray-500">No Admin found.</p>
        @endif
    </div>

    <div class="mt-5">
        {{$admins->links()}}
    </div>

    @vite(['resources/js/admin/update.js'])
</x-layout>
