@component('mail::message')
# Room Booking {{$booking->status == 2 ? 'Finished' : 'Canceled'}}

@component('mail::panel')
A Room Booking {{$booking->status == 2 ? 'Is Finished' : 'Has Been Canceled'}}<br>

Room: {{$booking->room->name}}<br>
Agenda: {{$booking->purpose}}<br>
Time: {{date('l, j F Y', strtotime($booking->tanggal))}} - {{$booking->jam_awal}}.00 s/d {{$booking->jam_akhir}}.00<br>
Booked By: {{ucwords($booking->user->name)}}<br>

{{$booking->status == 2 ? 'Finished' : 'Canceled'}} At: {{date('l, j F Y - H:i', strtotime($booking->updated_at))}}<br>
@if($booking->status == -2)
Cancelation Reason: {{$booking->notes}}<br>
@endif
@endcomponent

@component('mail::button', ['url' => 'http://office.jtd.co.id/manage-rooms/'.($booking->status == 2 ? 'booking-list' : 'pending-list')])
Go To Site
@endcomponent

This mail is auto generated, please do not reply to this mail.

Thank You,<br>
{{ config('app.name') }}
@endcomponent
