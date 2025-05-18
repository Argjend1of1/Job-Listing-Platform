<div class="user-card"
     data-user-id="{{$user->id}}"
>
    <x-panel class="gap-x-5 md:gap-x-3 items-center">
        <div>
            <x-user-logo :$user/>
        </div>

        <div class="flex-1 flex flex-col">
            <div class="mb-3">
                <p class="font-bold text-sm mb-[-5px]">Name:</p>
                <a class="self-start text-sm text-gray-400">{{$user->name}}</a>
            </div>

            <div class="mb-2">
                <p class="font-bold text-sm mb-[-5px]">Email:</p>
                <a class="text-sm text-gray-400">{{$user->email}}</a>
            </div>
            <div class="flex justify-end" >
                <button id="promoteUser"
                        data-user-id="{{$user->id}}"
                        class="border-2 border-green-800 transition rounded-full text-[10px] py-1 px-4 font-bold ml-3 hover:bg-green-800 cursor-pointer"
                >
                    Promote
                </button>
            </div>
        </div>
    </x-panel>
</div>
