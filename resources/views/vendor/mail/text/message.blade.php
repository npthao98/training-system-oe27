@component('mail::layout')
    @slot('header')
    @endslot
    {{ $slot }}
    @slot('footer')
    @endslot
@endcomponent
