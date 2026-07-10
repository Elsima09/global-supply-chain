@extends('layouts.dashboard')

@section('content')


<div class="container-fluid">


<div class="card futuristic-card border-0">

<div class="card-body">


<h2 class="text-info fw-bold mb-4">
🗺 Global Port Monitoring
</h2>


<div id="portMap"
style="
height:650px;
border-radius:20px;
overflow:hidden;
">
</div>


<div style="
margin-top:15px;
color:white;
font-size:16px;
">

🟢 Low Risk &nbsp;&nbsp;
🟡 Medium Risk &nbsp;&nbsp;
🔴 High Risk

</div>


</div>

</div>


</div>



<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


<script>

setTimeout(function(){


var map = L.map('portMap').setView(
    [20,0],
    2
);



L.tileLayer(
'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
{
    attribution:'© OpenStreetMap'
}
).addTo(map);



@foreach($ports as $port)


var risk = {{ $port->countryModel->riskScore->total_score ?? 0 }};


var color = "#22c55e";


if(risk >= 70){

    color="#ef4444";

}
else if(risk >=40){

    color="#eab308";

}



L.circleMarker(

[
{{ $port->latitude }},
{{ $port->longitude }}
],

{

radius:14,

fillColor:color,

color:"#fff",

weight:2,

fillOpacity:0.9

}

)

.addTo(map)

.bindPopup(
"<b>🚢 {{ $port->port_name }}</b><br>" +
"Country : {{ $port->country }}<br>" +
"AI Risk Score : <b>" + risk + "</b><br>" +
"Risk Level : {{ $port->countryModel->riskScore->risk_level ?? 'Unknown' }}"
);


@endforeach



map.invalidateSize();


},500);


</script>


@endsection