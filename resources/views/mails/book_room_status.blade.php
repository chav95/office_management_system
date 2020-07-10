@component('mail::message')
# Room Booking Approval

@component('mail::panel')
A Room You Booked Has Been {{$booking->status == 1 ? 'Approved' : 'Rejected'}}<br>
Agenda: {{$booking->purpose}}<br>
Time: {{date('l, j F Y', strtotime($booking->tanggal))}} - {{$booking->jam_awal}}.00 s/d {{$booking->jam_akhir}}.00<br><br>

@if($booking->status == 1)
Assigned Room: {{$booking->room->name}}<br>
@else
Rejection Note: {{$booking->notes}}<br>
@endif
@endcomponent

@component('mail::button', ['url' => 'http://office.jtd.co.id/manage-rooms/pending-list'])
Go To Site
@endcomponent

This mail is auto generated, please do not reply to this mail.

Thank You,<br>
{{ config('app.name') }}
@endcomponent
