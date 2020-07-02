@component('mail::message')
# Upcoming Maintenance

@component('mail::panel')
A Maintenance need to be processed.<br>
Name: {{$doc->name}}<br>
Due Date: {{date('l, j F Y', strtotime($doc->due_date))}}<br>

please complete the necessary process before the due time!
@endcomponent

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

This mail is auto generated, please do not reply to this mail.

Thanks,<br>
{{ config('app.name') }}
@endcomponent