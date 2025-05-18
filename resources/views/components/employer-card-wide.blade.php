<div class="employer-card"
     data-employer-id="{{$employer->id}}"
>
    <x-panel class="gap-x-5 md:gap-x-3 items-center">
        <div>
            <x-employer-logo :employer="$employer->user"/>
        </div>

        <div class="flex-1 flex flex-col">
            <div class="mb-3">
                <p class="font-bold text-sm mb-[-5px]">Name:</p>
                <a class="self-start text-sm text-gray-400">{{$employer->user->name}}</a>
            </div>

            <div class="mb-2">
                <p class="font-bold text-sm mb-[-5px]">Company Name:</p>
                <a class="text-sm text-gray-400">{{$employer->name}}</a>
            </div>
            <div class="flex justify-end" >
                @if($employer->user->role === 'employer')
                    <button id="promoteEmployer"
                            data-user-id="{{$employer->user->id}}"
                            class="border-2 border-green-800 transition rounded-full text-[10px] py-1 px-4 font-bold ml-3 hover:bg-green-800 cursor-pointer"
                    >
                        Promote
                    </button>
                    <button id="deleteEmployer"
                            data-employer-id="{{$employer->id}}"
                            class="border-2 border-red-800 transition rounded-full text-[10px] py-1 px-4 font-bold ml-3 hover:bg-red-800 cursor-pointer"
                    >
                        Remove
                    </button>
                @else
                    <button id="demoteEmployer"
                            data-employer-id="{{$employer->user->id}}"
                            class="border-2 border-red-800 transition rounded-full text-[10px] py-1 px-4 font-bold ml-3 hover:bg-red-800 cursor-pointer"
                    >
                        Demote
                    </button>
                @endif
            </div>
        </div>
    </x-panel>
</div>
