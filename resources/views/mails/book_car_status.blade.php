@component('mail::message')
# Car Booking Approval

@component('mail::panel')
A Car You Booked Has Been {{$booking->status == 1 ? 'Approved' : 'Rejected'}}<br>
Agenda: {{$booking->purpose}}<br>
Destination: {{$booking->destination}}<br>
At date: {{date('l, j F Y', strtotime($booking->tanggal))}} - {{$booking->jam_awal}}.00<br><br>

@if($booking->status == 1)
Assigned Car: {{$booking->car->type}} - {{$booking->car->police_number}}<br>
Assigned Driver: {{ucwords($booking->driver->name)}}<br>
@else
Rejection Note: {{$booking->notes}}<br>
@endif
@endcomponent

@component('mail::button', ['url' => 'http://office.jtd.co.id/manage-cars/pending-list'])
Go To Site
@endcomponent

This mail is auto generated, please do not reply to this mail.

Thank You,<br>
{{ config('app.name') }}
@endcomponent