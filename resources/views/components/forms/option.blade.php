@props(['value'])
@php
    $defaults = [
        'value' => $value,
        'class' => 'text-black'
    ];
@endphp
<option {{$attributes($defaults)}}>{{$slot}}</option>
