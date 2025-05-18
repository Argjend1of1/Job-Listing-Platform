<x-panel class="flex-col text-center">
    <div class="py-8">
        <h3 class="font-bold group-hover:text-blue-900 transition-colors duration-200 hover:underline">
            <a href="/companies/{{$employer->id}}/jobs">
                {{$employer->name}}
            </a>
        </h3>
        <a href="/categories/{{$employer->category->name}}"
           class="text-xs text-gray-400 mt-1.5 hover:underline"
        >
            {{$employer->category->name}}
        </a>
    </div>

    <div class="flex justify-center items-center mt-auto">
        <x-employer-logo :employer="$employer->user" :width="42"/>
    </div>
</x-panel>
