@php
    $defaultClasses = 'p-4 bg-white/10 rounded-xl mt-3 flex border border-transparent hover:border-blue-900 cursor-pointer group transition-colors duration-200'
@endphp

<div {{$attributes(['class' => $defaultClasses])}}>
    {{$slot}}
</div>
