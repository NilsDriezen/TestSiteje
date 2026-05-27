<x-mail::message>
# Beste {{ $data['name'] }},

Bedankt voor je bericht.
We hebben het goed ontvangen en zullen zo snel mogelijk contact met je opnemen.


<br>
<b>Uw bericht:</b>
<br>

<em>{!! nl2br($data['message']) !!}</em>
<br>
<br>

{!! nl2br($data['emailContentAdmin']) !!}

{{ $data['signature'] }}
</x-mail::message>
