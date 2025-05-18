<div class="admin-card"
     data-admin-id="{{$admin->id}}"
>
    <x-panel class="gap-x-5 md:gap-x-3 items-center">
        <div>
            <x-admin-logo :$admin/>
        </div>

        <div class="flex-1 flex flex-col">
            <div class="">
                <p class="font-bold text-sm mb-[-5px]">Name:</p>
                <a class="self-start text-sm text-gray-400">{{$admin->name}}</a>
            </div>


            <div class="mb-5 mt-2">
                <p class="font-bold text-sm mb-[-5px]">Email:</p>
                <a class="text-sm text-gray-400">{{$admin->email}}</a>
            </div>
            <div class="flex justify-end" >
                <button id="demoteAdmin"
                        data-admin-id="{{$admin->id}}"
                        class="border-2 border-red-800 transition rounded-full text-[10px] py-1 px-4 font-bold ml-3 hover:bg-red-800 cursor-pointer"
                >
                    Demote
                </button>
            </div>
        </div>
    </x-panel>
</div>
