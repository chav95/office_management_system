@component('mail::message')
# Car Booking {{$booking->status == 2 ? 'Finished' : 'Canceled'}}

@component('mail::panel')
A Car Booking {{$booking->status == 2 ? 'Is Finished' : 'Has Been Canceled'}}<br>

Agenda: {{$booking->purpose}}<br>
Destination: {{$booking->destination}}<br>
At date: {{date('l, j F Y', strtotime($booking->tanggal))}} - {{$booking->jam_awal}}.00<br>
Booked By: {{ucwords($booking->user->name)}}<br>

Assigned Car: {{$booking->car->type}} - {{$booking->car->police_number}}<br>
Assigned Driver: {{ucwords($booking->driver->name)}}<br>

{{$booking->status == 2 ? 'Finished' : 'Canceled'}} At: {{date('l, j F Y - H:i', strtotime($booking->updated_at))}}<br>
@if($booking->status == -2)
Cancelation Reason: {{$booking->notes}}<br>
@endif
@endcomponent

@component('mail::button', ['url' => 'http://office.jtd.co.id/manage-cars/'.($booking->status == 2 ? 'booking-list' : 'pending-list')])
Go To Site
@endcomponent

This mail is auto generated, please do not reply to this mail.

Thank You,<br>
{{ config('app.name') }}
@endcomponent