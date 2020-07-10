@component('mail::message')
# New Car Booking

@component('mail::panel')
New car booking has been requested for:<br>
Agenda: {{$booking->purpose}}<br>
Destination: {{$booking->destination}}<br>
At date: {{date('l, j F Y', strtotime($booking->tanggal))}} - {{$booking->jam_awal}}.00<br>
Booked By: {{ucwords($booking->user->name)}}<br>
@endcomponent

@component('mail::button', ['url' => 'http://office.jtd.co.id/manage-cars/pending-list'])
Go To Site
@endcomponent

This mail is auto generated, please do not reply to this mail.

Thank You,<br>
{{ config('app.name') }}
@endcomponent