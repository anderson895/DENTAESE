@props(['href', 'icon', 'label', 'badge' => 0])

@php
    $active = Request::is(trim($href, '/'));
@endphp

<a href="{{ $href }}"
   class="flex items-center gap-3 px-3 py-2 rounded-md transition-all duration-200
   {{ $active ? 'bg-primary text-white' : 'hover:bg-navItem hover:text-white text-accent' }}">
   <i class="{{ $icon }} text-base"></i>
   <span>{{ $label }}</span>
   @if(($badge ?? 0) > 0)
       <span class="ml-auto inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-xs font-bold text-white bg-red-500 rounded-full">{{ $badge }}</span>
   @endif
</a>
