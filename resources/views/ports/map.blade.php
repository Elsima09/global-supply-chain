@extends('layouts.dashboard')

@section('content')


<div class="container-fluid">


<div class="card futuristic-card border-0">


<div class="card-body">



<h2 class="text-info fw-bold mb-4">

🗺 Global Port Risk Monitoring

</h2>



<div id="portMap"

style="
height:650px;
border-radius:20px;
overflow:hidden;
">

</div>



<div class="mt-3 text-white">

🟢 Low Risk
&nbsp;&nbsp;

🟡 Medium Risk
&nbsp;&nbsp;

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

)

.addTo(map);







@foreach($ports as $port)



@php


$risk = $port->transport_risk ?? 0;



if($risk >= 70){

$level = "High";

$color = "#ef4444";

}

elseif($risk >=40){

$level = "Medium";

$color = "#eab308";

}

else{

$level = "Low";

$color = "#22c55e";

}



@endphp





L.circleMarker(

[

{{ $port->latitude }},

{{ $port->longitude }}

],

{


radius:14,


fillColor:"{{ $color }}",


color:"#ffffff",


weight:2,


fillOpacity:0.9


}

)


.addTo(map)



.bindPopup(

`

<div style="min-width:220px">


<h5>

🚢 {{ $port->port_name }}

</h5>



<hr>



🌎 Country:

<br>

<b>

{{ $port->country->name ?? '-' }}

</b>



<br><br>



🤖 AI Logistics Risk:

<br>

<b>

{{ $risk }}

</b>



<br><br>



Risk Level:

<br>

<span>

{{ $level }}

</span>



<br><br>



Status:

<br>

<b>

{{ ucfirst($port->status) }}

</b>



<br><br>



📍 Location:

<br>

{{ $port->latitude }},

{{ $port->longitude }}



</div>

`

);



@endforeach






setTimeout(()=>{

map.invalidateSize();

},500);



},500);



</script>



@endsection