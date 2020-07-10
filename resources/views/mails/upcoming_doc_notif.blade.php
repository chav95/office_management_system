@component('mail::message')
# Upcoming Document

@component('mail::panel')
A Documentneed to be processed.<br>
Name: {{$doc->name}}<br>
Due Date: {{date('l, j F Y', strtotime($doc->due_date))}}<br>

please complete the necessary process before the due time!
@endcomponent

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

This mail is auto generated, please do not reply to this mail.

Thank You,<br>
{{ config('app.name') }}
@endcomponent