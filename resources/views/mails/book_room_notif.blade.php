@component('mail::message')
# New Room Booking

@component('mail::panel')
New room booking has been requested for:<br>
Agenda: {{$booking->purpose}}<br>
Time: {{date('l, j F Y', strtotime($booking->tanggal))}} - {{$booking->jam_awal}}.00 s/d {{$booking->jam_akhir}}<br>
@endcomponent

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

This mail is auto generated, please do not reply to this mail.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
