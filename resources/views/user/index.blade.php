<x-layout>
    <x-page-heading>
        {{ isset($query) && $query ? "Search Results for \"$query\"" : 'Users' }}
    </x-page-heading>
    <x-forms.form class="mt-6 mb-10" action="/admins/create">
        <x-forms.input :label="false" name="q" value="{{$query ?? null}}" placeholder="Search Users..." />
    </x-forms.form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @if($users->first() !== null)
            @foreach($users as $user)
                <x-user-card :$user/>
            @endforeach
        @else
            <p class="text-lg text-gray-500">No User found.</p>
        @endif
    </div>

    <div class="mt-5">
        {{$users->links()}}
    </div>

    @vite(['resources/js/user/update.js'])
</x-layout>
