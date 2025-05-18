@props(['width' => 90, 'user'])

<img class="rounded-xl" src="{{asset($user->logo)}}" width="{{$width}}" alt="logo" />
