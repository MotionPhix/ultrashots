<x-mail::message>

{{ $message }}

{{-- <x-mail::panel>
Button Text
</x-mail::panel> --}}

<br>
**{{ $user->first_name }}**, {{ config('app.name') }}
</x-mail::message>
