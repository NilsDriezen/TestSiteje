<x-mail::message>
# Beste {{ $data['name'] }},

{!! nl2br($data['message']) !!}

Tot dan!<br><br>
    {{ $data['signature'] }}
</x-mail::message>
