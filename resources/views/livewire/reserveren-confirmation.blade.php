<div>

    <p>
    We hebben uw reservatie ontvangen en kijken ernaar uit om u en uw gezelschap binnenkort te verwelkomen.
        Wij hebben de volgende gegevens doorgekregen in uw reservatie:</p>
    <br>
    <p><strong>Datum:</strong> {{ $reservation['date'] }}</p>
    <p><strong>Tijdslot:</strong> {{ $reservation['time_slot'] }}</p>
    <br>
    <p><strong>Aantal personen:</strong> {{ $reservation['number_of_person'] }}</p>
    <p><strong>Aantal vegetarisch menu:</strong> {{ $reservation['quantity'] }}</p>
    <p><strong>4-gangenmenu:</strong> {{ $reservation['is_four_course'] ? 'Ja' : 'Nee' }}</p>
    <p><strong>Opmerkingen:</strong> {{ $reservation['comment'] }}</p>
    <br>
    <p><strong>Naam:</strong> {{ $reservation['customer_name'] }}</p>
    <p><strong>Telefoonnummer:</strong> {{ $reservation['customer_phone_number'] }}</p>
    <p><strong>Emailadres:</strong> {{ $reservation['customer_email'] }}</p>
    <br>
    <p>
        Een bevestigingsmail met alle details van uw reservering wordt spoedig naar het e-mailadres {{ $reservation['customer_email'] }} gestuurd.<br>
        Mocht u nog vragen hebben of aanvullende informatie nodig hebben, aarzel dan niet om contact met ons op te nemen.<br><br>

        We kijken ernaar uit om u een heerlijke ervaring te bezorgen!
    </p>
    <br>
    <a href="{{ route('koekjes') }}"><u>Bestel alvast koekjes om thuis van te genieten</u></a>
</div>
