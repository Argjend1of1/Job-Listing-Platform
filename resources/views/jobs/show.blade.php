@php use Illuminate\Support\Facades\Auth; @endphp
<x-layout>
    <div class="max-w-3xl mx-auto space-y-8" id="jobContainer">
        <x-page-heading>Job Information</x-page-heading>
        <div class="space-y-5">
            <div>
                <p class="text-lg text-white font-semibold">Title:</p>
                <p class="text-gray-400 text-base">{{$job->title}}</p>
            </div>

            <div>
                <p class="text-lg text-white font-semibold">Company:</p>
                <a href="/companies/{{$job->employer->id}}/jobs"
                   class="text-gray-400 text-base hover:underline"
                >
                    {{$job->employer->name}}
                </a>
            </div>

            <div>
                <p class="text-lg text-white font-semibold">About:</p>
                <div class="prose prose-invert max-w-none text-gray-400">
                    {!! $job->about !!}
                </div>
            </div>

            <div>
                <p class="text-lg text-white font-semibold">Schedule:</p>
                <p class="text-gray-400 text-base">{{$job->schedule}}</p>
            </div>

            <div>
                <p class="text-lg text-white font-semibold">Location:</p>
                <p class="text-gray-400 text-base">{{$job->location}}</p>
            </div>

            <div>
                <p class="text-lg text-white font-semibold">Salary:</p>
                <p class="text-gray-400 text-base">{{$job->salary}}</p>
            </div>
            <hr class="text-gray-900">

            <div class="flex">
                @guest
                    <div class="pt-6 flex w-full">
                        <button
                            id="applyButton"
                            data-job-id="{{$job->id}}"
                            class="inline-block mr-1.5 px-6 py-2 border-2 border-green-700 text-white hover:bg-green-700 transition rounded-full cursor-pointer focus:bg-gray-800"
                        >
                            Apply Here
                        </button>
                        <button
                            id="bookmarkButton"
                            data-job-id="{{$job->id}}"
                            class="inline-block mr-1.5 px-6 py-2 border-2 border-gray-700 text-white hover:bg-gray-700 transition rounded-full cursor-pointer focus:bg-gray-800"
                        >
                            Bookmark
                        </button>
                    </div>
                @endguest

                @auth
                    @if(Auth::user()->role === 'user')
                        <div class="pt-6 flex w-full">
                            <button
                                id="applyButton"
                                data-job-id="{{$job->id}}"
                                class="inline-block mr-1.5 px-6 py-2 border-2 border-green-700 text-white hover:bg-green-700 transition rounded-full cursor-pointer"
                            >
                                Apply Here
                            </button>
                            <button
                                id="bookmarkButton"
                                data-job-id="{{$job->id}}"
                                class="inline-block mr-1.5 px-6 py-2 border-2 border-gray-700 text-white hover:bg-gray-700 transition rounded-full cursor-pointer"
                            >
                                Bookmark
                            </button>
                        </div>
                    @endif

                    @if(!in_array(Auth::user()->role, ['admin', 'superadmin']))
                        <div class="pt-6 flex w-full">
                            <button
                                id="reportButton"
                                data-job-id="{{$job->id}}"
                                class="ml-auto inline-block px-6 py-2 border-2 border-red-700 text-white hover:bg-red-700 transition rounded-full cursor-pointer focus:bg-red-700"
                            >
                                Report Job
                            </button>
                        </div>
                    @endif

                    @if(in_array(Auth::user()->role, ['admin', 'superadmin']))
                        <div class="pt-6">
                            <button
                                id="deleteButton"
                                data-job-id="{{$job->id}}"
                                class="inline-block px-6 py-2 border-2 border-red-700 text-white hover:bg-red-700 transition rounded-full cursor-pointer focus:bg-red-700"
                            >
                                Delete Job
                            </button>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    @vite('resources/js/application/store.js')
</x-layout>
