<x-mail::message>
# Introduction

Sofra

@component('mail::button', ['url' => 'http://google.com'])
Reset
@endcomponent

{{-- <x-mail::button :url="''">
Reset
</x-mail::button> --}}

<p class="text-center">Reset Password Is : {{ $pin_code }}</p>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
