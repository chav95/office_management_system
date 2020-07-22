@component('mail::message')
# New Room Booking

@component('mail::panel')
New room booking has been requested for:<br>
Room: {{$booking->room->name}}<br>
Agenda: {{$booking->purpose}}<br>
Time: {{date('l, j F Y', strtotime($booking->tanggal))}} - {{$booking->jam_awal}}.00 s/d {{$booking->jam_akhir}}.00<br>
Booked By: {{ucwords($booking->user->name)}}<br>
@endcomponent

@component('mail::button', ['url' => 'http://office.jtd.co.id/manage-rooms/pending-list'])
Go To Site
@endcomponent

This mail is auto generated, please do not reply to this mail.

Thank You,<br>
{{ config('app.name') }}
@endcomponent
