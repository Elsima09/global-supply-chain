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



var map = L.map('portMap')
.setView(
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


@php

$risk = $port->country?->riskScore?->total_score ?? 0;

$level = $port->country?->riskScore?->risk_level ?? 'Unknown';

@endphp



var risk = {{ $risk }};



var color="#22c55e";



if(risk >=70){

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

color:"#ffffff",

weight:2,

fillOpacity:0.9


}

)

.addTo(map)



.bindPopup(

`

<b>🚢 {{ $port->port_name }}</b>
<br>

Country :
{{ $port->country->name ?? '-' }}

<br>

AI Risk Score :
<b>${risk}</b>

<br>

Risk Level :
<b>{{ $level }}</b>

<br>

Status :
{{ $port->status }}

<br>

Delay :
{{ $port->delay_hours ?? 0 }} Hours

<br>

Capacity :
{{ $port->capacity ?? 0 }}%

<br>

Congestion :
{{ $port->congestion ?? 'Low' }}

`

);



@endforeach





setTimeout(()=>{

map.invalidateSize();

},500);



},500);



</script>


@endsection