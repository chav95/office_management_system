@component('mail::message')
# New Document

@component('mail::panel')
New Document has been created.<br>
Name: {{$doc->name}}<br>
{{-- To Be Notified: {{date('l, j F Y', strtotime($doc->notif_date))}}<br> --}}
Due Date: {{date('l, j F Y', strtotime($doc->due_date))}}<br>
@endcomponent

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

This mail is auto generated, please do not reply to this mail.

Thanks,<br>
{{ config('app.name') }}
@endcomponent