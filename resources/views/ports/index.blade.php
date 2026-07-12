@extends('layouts.dashboard')

@section('content')


<div class="card futuristic-card border-0">

<div class="card-body">


<h2 class="mb-4"
style="
color:#38bdf8;
text-shadow:0 0 12px #38bdf8;
">

🚢 Global Ports Monitoring

</h2>



<form method="GET"
action="{{ route('ports.index') }}"
class="mb-4">


<div style="display:flex;gap:10px;">


<input

type="text"

name="search"

value="{{ request('search') }}"

placeholder="Search port or country..."

class="form-control"

style="
background:#0f172a;
color:white;
border:1px solid rgba(56,189,248,.35);
"


>



<button class="btn btn-info">

Search

</button>



</div>


</form>





<div id="map"

style="
height:500px;
border-radius:18px;
overflow:hidden;
border:1px solid rgba(56,189,248,.25);
box-shadow:0 0 20px rgba(56,189,248,.15);
">

</div>



</div>

</div>





<div class="card futuristic-card border-0 mt-4">


<div class="card-body">



<h4 class="text-info fw-bold mb-4">

🌍 Port Database

</h4>




<table class="table table-bordered table-hover futuristic-table">


<thead>


<tr>

<th>ID</th>

<th>Port Name</th>

<th>Country</th>

<th>Location</th>

<th>Status</th>

<th>AI Logistics Risk</th>

<th>Level</th>


</tr>


</thead>




<tbody>


@foreach($ports as $port)


@php


$risk =
$port->transport_risk ?? 0;



if($risk >= 70){

$level="High";

$badge="danger";

}

elseif($risk >=40){

$level="Medium";

$badge="warning";

}

else{

$level="Low";

$badge="success";

}



@endphp



<tr>


<td>

{{ $port->id }}

</td>



<td>

🚢 {{ $port->port_name }}

</td>




<td>

🌎 {{ $port->country->name ?? '-' }}

</td>




<td>

{{ $port->latitude }},
{{ $port->longitude }}

</td>




<td>


@if($port->status=="active")


<span class="badge bg-success">

🟢 Active

</span>


@elseif($port->status=="maintenance")


<span class="badge bg-warning text-dark">

🟡 Maintenance

</span>


@else


<span class="badge bg-danger">

🔴 Closed

</span>


@endif


</td>




<td>


<b class="text-info">

{{ $risk }}

</b>


</td>




<td>


<span class="badge bg-{{ $badge }}">

{{ $level }}

</span>


</td>



</tr>



@endforeach



</tbody>



</table>



</div>

</div>







{{-- LEAFLET --}}


<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>



<script>


document.addEventListener(
'DOMContentLoaded',
function(){



var map = L.map('map')
.setView(
[20,110],
3
);





L.tileLayer(

'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',

{

attribution:'© OpenStreetMap'

}

).addTo(map);





@foreach($ports as $port)



@php


$risk =
$port->transport_risk ?? 0;



$color="#22c55e";


if($risk>=70){

$color="#ef4444";

}

elseif($risk>=40){

$color="#eab308";

}



@endphp





L.circleMarker(

[

{{ $port->latitude }},

{{ $port->longitude }}

],

{


radius:12,


fillColor:"{{ $color }}",


color:"#ffffff",


weight:2,


fillOpacity:.9


}


)


.addTo(map)



.bindPopup(

`

<b>🚢 {{ $port->port_name }}</b>

<br>

🌎 Country :
{{ $port->country->name ?? '-' }}

<br>


📍 Location :

{{ $port->latitude }},
{{ $port->longitude }}


<br>


🤖 AI Logistics Risk :

<b>{{ $risk }}</b>


<br>


Status :

{{ ucfirst($port->status) }}


`

);



@endforeach






setTimeout(()=>{

map.invalidateSize();

},500);



});



</script>



@endsection