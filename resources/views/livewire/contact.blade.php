<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>



<div class="md:w-4/5">

<div class="flex sm:flex-row flex-col gap-8 xl:gap-60">
    <div class="flex-col">
        <h2 class="text-2xl font-bold my-4">Openingsuren</h2>
        <table class="table-auto">
<table class="table-auto w-full divide-y divide-x border shadow rounded">
    <tbody>
    @foreach($dagen as $dag => $tijden)
        <tr>
            <td class="border px-4 py-2">{{ __($dag) }}</td>
            <td class="border px-4 py-2">
            @foreach($tijden as $tijd)
                {{ date('H:i', strtotime($tijd->time_start)) }}u - {{ date('H:i', strtotime($tijd->time_end)) }}u<br>
            @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@if ($speciale_dagen->count())
    <div class="mt-4">
        <h3 class="text-xl font-bold my-4">Uitzonderlijk open op</h3>
        <table class="table-auto w-full divide-y divide-x border shadow rounded">
            <tbody>
            @foreach($speciale_dagen as $dag => $tijden)
                <tr>
                    <td class="border px-4 py-2">{{ __(date('l', strtotime($dag))) . ' ' . __($dag) }}</td>
                    <td class="border px-4 py-2">
                    @foreach($tijden as $tijd)
                        {{ date('H:i', strtotime($tijd->time_start)) }}u - {{ date('H:i', strtotime($tijd->time_end)) }}u<br>
                    @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
    </div>
<div id="map" class="w-full sm:w-2/5 mt-4 h-64 sm:h-auto border shadow p-4 bg-white"></div>
</div>

    <div>
        <p class="text-lg mt-4">{!! nl2br(e($template_webpage->content)) !!}</p>
    </div>

    <div class="w-full sm:w-3/5 mt-4">  @livewire('contact-form')</div>


    {{--              logger--}}
{{--    <x-tmk.livewire-log :template_webpage="$template_webpage" :dagen="$dagen" :speciale_dagen="$speciale_dagen"/>--}}

</div>


<script>
    // Initialiseer de kaart
    var map = L.map('map').setView([51.2194475, 4.4024643], 13);

    // Voeg een Tile Layer toe aan de kaart
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Voeg een marker toe aan de kaart
    L.marker([51.2194475, 4.4024643]).addTo(map)
L.marker([51.2194475, 4.4024643]).addTo(map)
    .bindPopup('<h3 class="text-xl">Huiskamer</h3>Dagschotelstraat 7<br>2000 Antwerpen<br><br> ' +
        '<span style="display: flex; align-items: center;">' +
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" style="height: 16px; margin-right: 5px;"><path d="M144.27,45.93a8,8,0,0,1,9.8-5.66,86.22,86.22,0,0,1,61.66,61.66,8,8,0,0,1-5.66,9.8A8.23,8.23,0,0,1,208,112a8,8,0,0,1-7.73-5.94,70.35,70.35,0,0,0-50.33-50.33A8,8,0,0,1,144.27,45.93Zm-2.33,41.8c13.79,3.68,22.65,12.54,26.33,26.33A8,8,0,0,0,176,120a8.23,8.23,0,0,0,2.07-.27,8,8,0,0,0,5.66-9.8c-5.12-19.16-18.5-32.54-37.66-37.66a8,8,0,1,0-4.13,15.46Zm81.94,95.35A56.26,56.26,0,0,1,168,232C88.6,232,24,167.4,24,88A56.26,56.26,0,0,1,72.92,32.12a16,16,0,0,1,16.62,9.52l21.12,47.15,0,.12A16,16,0,0,1,109.39,104c-.18.27-.37.52-.57.77L88,129.45c7.49,15.22,23.41,31,38.83,38.51l24.34-20.71a8.12,8.12,0,0,1,.75-.56,16,16,0,0,1,15.17-1.4l.13.06,47.11,21.11A16,16,0,0,1,223.88,183.08Zm-15.88-2s-.07,0-.11,0h0l-47-21.05-24.35,20.71a8.44,8.44,0,0,1-.74.56,16,16,0,0,1-15.75,1.14c-18.73-9.05-37.4-27.58-46.46-46.11a16,16,0,0,1,1-15.7,6.13,6.13,0,0,1,.57-.77L96,95.15l-21-47a.61.61,0,0,1,0-.12A40.2,40.2,0,0,0,40,88,128.14,128.14,0,0,0,168,216,40.21,40.21,0,0,0,208,181.07Z"/>' +
        '</svg><a href="tel:+32123456789">+32 (0)123/45 67 89</a></span>  ' +
        '<span style="display: flex; align-items: center;">' +
        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" style="height: 16px; margin-right: 5px;"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>' +
        '</svg><a href="mailto:mieke@huiskamer.be">mieke@huiskamer.be</a></span>', {autoPan: true})
    .openPopup();
</script>



