<x-panel class="flex-col text-center">
    <div class="py-3">
        <h3 class="font-bold  text-2xl group-hover:text-blue-900 transition-colors duration-200">
            {{$application->user->name}}
        </h3>
        <p class="text-sm text-gray-400 mt-1.5">{{$application->user->email}}</p>
    </div>

    <div class="flex justify-between items-center mt-auto">
        <a
            href="{{ route('resume.download', [$application->user_id, $application->job_id]) }}"
            class="flex items-center border-2 border-green-800 transition rounded-full text-[10px] py-1 px-4 font-bold ml-3 hover:bg-green-800 cursor-pointer"
        >
            <p class="mr-3">Resume</p>
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-4 h-4 mr-1"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
            </svg>
        </a>

        <x-employer-logo :employer="$application->user" :width="42"/>
    </div>
</x-panel>
