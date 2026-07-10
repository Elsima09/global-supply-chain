@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">

    {{-- ============================= --}}
    {{-- PAGE HEADER --}}
    {{-- ============================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold text-info" style="text-shadow:0 0 12px #38bdf8;">
                💱 Currency Monitoring
            </h2>

            <p class="text-secondary mb-0">
                Monitor global exchange rates across all countries in real time.
            </p>

        </div>

        <div>

            <span class="badge bg-success fs-6 px-3 py-2">

                Last Update :
                {{ now()->format('d M Y H:i') }}

            </span>

        </div>

    </div>


    {{-- ============================= --}}
    {{-- SUMMARY CARD --}}
    {{-- ============================= --}}

    <div class="row g-4 mb-4">

        {{-- Total Currency --}}

        <div class="col-xl-3 col-md-6">

            <div class="card futuristic-card border-0 h-100">

                <div class="card-body">

                    <small class="text-secondary">

                        Total Currency

                    </small>

                    <h2 class="text-info fw-bold mt-2">

                        {{ $totalCurrency }}

                    </h2>

                    <small class="text-secondary">

                        Active Currency Codes

                    </small>

                </div>

            </div>

        </div>



        {{-- Highest Rate --}}

        <div class="col-xl-3 col-md-6">

            <div class="card futuristic-card border-0 h-100">

                <div class="card-body">

                    <small class="text-secondary">

                        Highest Exchange Rate

                    </small>

                    <h3 class="text-danger fw-bold mt-2">

                        {{ $highestCurrency['currency'] }}

                    </h3>

                    <div class="text-white">

                        {{ number_format($highestCurrency['rate'],2) }}

                    </div>

                    <small class="text-secondary">

                        {{ $highestCurrency['country'] }}

                    </small>

                </div>

            </div>

        </div>



        {{-- Lowest Rate --}}

        <div class="col-xl-3 col-md-6">

            <div class="card futuristic-card border-0 h-100">

                <div class="card-body">

                    <small class="text-secondary">

                        Lowest Exchange Rate

                    </small>

                    <h3 class="text-success fw-bold mt-2">

                        {{ $lowestCurrency['currency'] }}

                    </h3>

                    <div class="text-white">

                        {{ number_format($lowestCurrency['rate'],2) }}

                    </div>

                    <small class="text-secondary">

                        {{ $lowestCurrency['country'] }}

                    </small>

                </div>

            </div>

        </div>



        {{-- Average Rate --}}

        <div class="col-xl-3 col-md-6">

            <div class="card futuristic-card border-0 h-100">

                <div class="card-body">

                    <small class="text-secondary">

                        Average Exchange Rate

                    </small>

                    <h3 class="text-warning fw-bold mt-2">

                        {{ number_format(collect($currencyData)->avg('rate'),2) }}

                    </h3>

                    <small class="text-secondary">

                        USD Base Currency

                    </small>

                </div>

            </div>

        </div>

    </div>



    {{-- ============================= --}}
    {{-- FILTER --}}
    {{-- ============================= --}}

    <div class="card futuristic-card border-0 mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-5">

                    <input

                        type="text"

                        id="searchCurrency"

                        class="form-control"

                        placeholder="🔍 Search Country or Currency..."

                    >

                </div>



                <div class="col-md-3">

                    <select

                        id="trendFilter"

                        class="form-select"

                    >

                        <option value="">

                            All Trend

                        </option>

                        <option value="High">

                            High

                        </option>

                        <option value="Medium">

                            Medium

                        </option>

                        <option value="Low">

                            Low

                        </option>

                    </select>

                </div>



                <div class="col-md-4 text-end">

                    <button

                        class="btn btn-info"

                        onclick="location.reload()"

                    >

                        🔄 Refresh Table

                    </button>

                </div>

            </div>

        </div>

    </div>

        {{-- ============================= --}}
    {{-- CURRENCY TABLE --}}
    {{-- ============================= --}}

    <div class="card futuristic-card border-0 mb-4">

        <div class="card-body">

            <h4 class="text-info mb-4">

                🌍 Global Currency Exchange Table

            </h4>

            <div class="table-responsive">

                <table
                    class="table table-hover align-middle futuristic-table"
                    id="currencyTable">

                    <thead>

                        <tr>

                            <th width="70">#</th>

                            <th>Country</th>

                            <th>Region</th>

                            <th>Currency</th>

                            <th class="text-end">Exchange Rate</th>

                            <th class="text-center">Trend</th>

                            <th class="text-center">Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($currencyData as $index=>$item)

                        <tr>

                            <td>

                                <span class="badge bg-secondary">

                                    {{ $index+1 }}

                                </span>

                            </td>

                            <td>

                                <strong>

                                    {{ $item['country'] }}

                                </strong>

                            </td>

                            <td>

                                <span class="text-info">

                                    {{ $item['region'] }}

                                </span>

                            </td>

                            <td>

                                <span class="badge bg-primary">

                                    {{ $item['currency'] }}

                                </span>

                            </td>

                            <td class="text-end">

                                <strong>

                                    {{ number_format($item['rate'],2) }}

                                </strong>

                            </td>

                            <td class="text-center">

                                @if($item['trend']=="High")

                                    <span class="badge bg-danger">

                                        High

                                    </span>

                                @elseif($item['trend']=="Medium")

                                    <span class="badge bg-warning text-dark">

                                        Medium

                                    </span>

                                @else

                                    <span class="badge bg-success">

                                        Low

                                    </span>

                                @endif

                            </td>

                            <td class="text-center">

                                @if($item['trend']=="High")

                                    🔴

                                @elseif($item['trend']=="Medium")

                                    🟡

                                @else

                                    🟢

                                @endif

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

        <div class="row">

    {{-- Top Currency Chart --}}
    <div class="col-lg-8">

        <div class="card futuristic-card border-0 mb-4">

            <div class="card-body">

                <h4 class="text-info mb-4">
                    📈 Top 10 Highest Exchange Rate
                </h4>

                <div style="height:400px">

                    <canvas id="currencyChart"></canvas>

                </div>

            </div>

        </div>

    </div>

    {{-- Region Chart --}}
    <div class="col-lg-4">

        <div class="card futuristic-card border-0 mb-4">

            <div class="card-body">

                <h4 class="text-info mb-4">
                    🌍Currency by Region
                </h4>

                <div style="height:400px">

                    <canvas id="regionChart"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

    <script>

document.getElementById("searchCurrency").addEventListener("keyup",function(){

let value=this.value.toLowerCase();

let rows=document.querySelectorAll("#currencyTable tbody tr");

rows.forEach(function(row){

let text=row.innerText.toLowerCase();

row.style.display=text.includes(value)?"":"none";

});

});

</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx=document.getElementById('currencyChart');

if(ctx){

new Chart(ctx,{

type:'bar',

data:{

labels:@json($currencyLabels),

datasets:[{

label:'Exchange Rate',

data:@json($currencyValues),

backgroundColor:[

'#38bdf8',
'#0ea5e9',
'#06b6d4',
'#14b8a6',
'#22c55e',
'#84cc16',
'#eab308',
'#f97316',
'#ef4444',
'#8b5cf6'

],

borderRadius:10

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

plugins:{

legend:{

labels:{

color:'white'

}

}

},

scales:{

x:{

ticks:{

color:'white'

}

},

y:{

ticks:{

color:'white'

}

}

}

}

});

}

</script>
<script>

const region = document.getElementById('regionChart');

if(region){

new Chart(region,{

type:'pie',

data:{

labels:@json($regionLabels),

datasets:[{

data:@json($regionValues),

backgroundColor:[

'#38bdf8',
'#22c55e',
'#eab308',
'#ef4444',
'#8b5cf6',
'#14b8a6',
'#f97316',
'#f43f5e',
'#6366f1',
'#10b981'

]

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

plugins:{

legend:{

position:'bottom',

labels:{

color:'white'

}

}

}

}

});

}

</script>

{{-- ================================================= --}}
{{-- AI CURRENCY INSIGHT --}}
{{-- ================================================= --}}

<div class="card futuristic-card border-0 mt-4">

    <div class="card-body">

        <h4 class="text-info mb-4">

            🤖 AI Currency Insight

        </h4>

        <div class="row">

            <div class="col-md-6">

                <ul class="list-group list-group-flush">

                    <li class="list-group-item bg-transparent text-white border-secondary">

                        💰 Highest Exchange Rate :
                        <strong class="text-danger">

                            {{ $highestCurrency['currency'] }}

                        </strong>

                    </li>

                    <li class="list-group-item bg-transparent text-white border-secondary">

                        💵 Lowest Exchange Rate :
                        <strong class="text-success">

                            {{ $lowestCurrency['currency'] }}

                        </strong>

                    </li>

                    <li class="list-group-item bg-transparent text-white border-secondary">

                        🌍 Total Currency :

                        <strong class="text-info">

                            {{ $totalCurrency }}

                        </strong>

                    </li>

                    <li class="list-group-item bg-transparent text-white border-secondary">

                        📊 Average Rate :

                        <strong class="text-warning">

                            {{ number_format(collect($currencyData)->avg('rate'),2) }}

                        </strong>

                    </li>

                </ul>

            </div>

            <div class="col-md-6">

                <div class="alert alert-info">

                    <h5>

                        AI Recommendation

                    </h5>

                    <p>

                        Monitor countries with extremely high exchange rates because they are more likely to experience currency volatility.

                    </p>

                    <p>

                        Stable currencies can be used as references for international trade.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection