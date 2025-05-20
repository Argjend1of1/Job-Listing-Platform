<x-panel class="flex-col text-center">
    <a href="/companies/{{$job->employer->id}}/jobs" class="self-start text-sm hover:underline">{{$job->employer->name}}</a>
    <div class="py-8">
        <h3 class="font-bold group-hover:text-blue-900 transition-colors duration-200">
            <a href="/jobs/{{$job->id}}/bookmark">
                {{$job->title}}
            </a>
        </h3>
        <p class="text-xs text-gray-400 mt-1.5">{{$job->schedule}}- {{$job->salary}}</p>
    </div>

    <div class="flex justify-between items-center mt-auto">
        <div>
            @foreach($job->tags as $tag)
                <x-tag :$tag class="text-[10px] px-3 py-1 mx-0.5"/>
            @endforeach
        </div>

        <x-employer-logo :employer="$job->employer->user" :width="42"/>
    </div>
</x-panel>
