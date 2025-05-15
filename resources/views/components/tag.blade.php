@props(['tag'])

<a {{$attributes(['class'=> "bg-white/15 rounded-xl font-bold transition-colors duration-200 hover:bg-white/25"])}}
   href="/tags/{{strtolower($tag->name)}}"
>
    {{$tag->name}}
</a>
