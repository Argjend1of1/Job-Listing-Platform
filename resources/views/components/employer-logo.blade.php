@props(['width' => 90, 'employer'])

<img class="rounded-xl" src="{{asset($employer->logo)}}" width="{{$width}}" alt="logo" />
