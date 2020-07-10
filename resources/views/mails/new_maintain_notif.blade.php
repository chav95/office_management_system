@component('mail::message')
# New Maintenance

@component('mail::panel')
New Maintenance has been created.<br>
Name: {{$doc->name}}<br>
Due Date: {{date('l, j F Y', strtotime($doc->due_date))}}<br>
@endcomponent

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

This mail is auto generated, please do not reply to this mail.

Thank You,<br>
{{ config('app.name') }}
@endcomponent