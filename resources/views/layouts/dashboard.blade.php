<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Supply Chain AI Dashboard</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


<style>
    body{
    margin:0;
    font-family: Arial, sans-serif;
}

.menu-link{
    border-radius:14px;
    transition:all .3s ease;
    padding:12px 16px !important;
}

.menu-link:hover{
    background:rgba(56,189,248,0.12);
    box-shadow:0 0 20px rgba(56,189,248,0.35);
    color:#38bdf8 !important;
    padding-left:22px !important;
}

.glow-text{
    color:#38bdf8 !important;
    text-shadow:0 0 8px rgba(56,189,248,0.7);
}

canvas{
    background:rgba(255,255,255,0.03);
    border-radius:16px;
    padding:15px;
}

.top-glow-line{
    height:2px;
    width:180px;
    background:linear-gradient(to right,transparent,#38bdf8,transparent);
    box-shadow:0 0 20px #38bdf8;
    margin:auto;
}
.futuristic-card{
    background: rgba(15,35,65,0.78) !important;
    backdrop-filter: blur(14px);
    border-radius: 20px;
    padding: 10px;
    color: white;
    transition: all .3s ease;
}

.futuristic-card:hover{
    transform: translateY(-3px);
    box-shadow:
    0 15px 40px rgba(56,189,248,.18);
}

/* Border warna per card */

.border-blue{
    border:1px solid rgba(56,189,248,0.7) !important;
    box-shadow:0 0 18px rgba(56,189,248,0.18);
}

.border-red{
    border:1px solid rgba(239,68,68,0.7) !important;
    box-shadow:0 0 18px rgba(239,68,68,0.18);
}

.border-green{
    border:1px solid rgba(34,197,94,0.7) !important;
    box-shadow:0 0 18px rgba(34,197,94,0.18);
}

.border-yellow{
    border:1px solid rgba(250,204,21,0.7) !important;
    box-shadow:0 0 18px rgba(250,204,21,0.18);
}

/* Angka glowing */
.number-blue{
    color:#38bdf8;
    text-shadow:0 0 15px #38bdf8;
    font-size:58px;
    font-weight:bold;
}

.number-red{
    color:#fb7185;
    text-shadow:0 0 15px #fb7185;
    font-size:58px;
    font-weight:bold;
}

.number-green{
    color:#4ade80;
    text-shadow:0 0 15px #4ade80;
    font-size:58px;
    font-weight:bold;
}

.number-yellow{
    color:#fde047;
    text-shadow:0 0 15px #fde047;
    font-size:58px;
    font-weight:bold;
}
.futuristic-card h1,
.futuristic-card h2,
.futuristic-card h3,
.futuristic-card h4,
.futuristic-card h5,
.futuristic-card h6,
.futuristic-card p,
.futuristic-card span,
.futuristic-card td,
.futuristic-card th {
    color: white !important;
}
.card-body small,
.card-body .text-muted {
    color: #cbd5e1 !important;
}

.futuristic-card:hover{
    transform: translateY(-4px);
    box-shadow: 0 0 30px rgba(34,211,238,0.25);
}
.futuristic-table{
    color:white !important;
}

.futuristic-table thead th{
    background: rgba(59,130,246,0.25) !important;
    color:#38bdf8 !important;
    border-color: rgba(56,189,248,0.2) !important;
}

.futuristic-table td{
    background: rgba(30,41,59,0.65) !important;
    color:white !important;
    border-color: rgba(56,189,248,0.15) !important;
}

.futuristic-table tr:hover td{
    background: rgba(56,189,248,0.08) !important;
}

.table td,
.table tbody tr td{
    background: rgba(15,23,42,0.6) !important;
    color: white !important;
}

.table thead th{
    background: rgba(59,130,246,0.25) !important;
    color: #38bdf8 !important;
}

.table{
    color:white !important;
}

.table-bordered{
    border-color: rgba(56,189,248,0.15) !important;
}

.table td,
.table th{
    padding: 16px !important;
}
.futuristic-table th{
    background: rgba(15,23,42,0.85) !important;
    color: #38bdf8 !important;
}

.progress-bar{

transition:width .8s ease;

}
</style>

</head>
<body style="
background: linear-gradient(135deg,#0f172a,#111827,#1e293b);
min-height:100vh;
color:white;
">

<div class="d-flex">

    <!-- Sidebar -->
   <div style="
width:280px;
min-height:100vh;
background:linear-gradient(180deg,#020617,#0f172a);
border-right:1px solid rgba(56,189,248,0.3);
box-shadow:0 0 20px rgba(56,189,248,0.15);
" class="text-white p-4">
        <h4 class="fw-bold mb-1 text-info">🌐 SupplyChain AI</h4>
<p style="font-size:13px;color:#94a3b8;">
    Risk Intelligence System
</p>

        <ul class="nav flex-column gap-2">
            <li>
    <a href="{{ route('dashboard') }}" class="nav-link text-white menu-link">🏠 Dashboard</a>
</li>

<li>
    <a href="{{ route('countries.index') }}" class="nav-link text-white menu-link"> 🌍 Countries</a>
</li>
            <li>
    <a href="{{ route('weather.index') }}" class="nav-link text-white menu-link">
        ☁ Weather
    </a>
</li>
            <li>
    <a href="{{ route('currency.index') }}" class="nav-link text-white menu-link">
        💱 Currency
    </a>
</li>
            <li>
    <a href="{{ route('news.index') }}" class="nav-link text-white menu-link">
        📰 News
    </a>
</li>
            <li>
    <a href="{{ route('ports.index') }}" 
       class="nav-link text-white menu-link">
        🚢 Ports
    </a>
</li>


<li>
    <a href="{{ route('ports.map') }}" 
       class="nav-link text-white menu-link">

        🗺 Port Monitoring

    </a>
</li>

            <a href="{{ route('comparison.index') }}" class="nav-link text-white menu-link">
    📊 Comparison
</a>
            <a href="{{ route('watchlist.index') }}" class="nav-link text-white menu-link">
    ⭐ Watchlist
</a>
<li>
    <a href="{{ route('sentiment.index') }}" class="nav-link text-white menu-link">
        🧠 Sentiment
    </a>
</li>
<li>
    <a href="{{ route('risk.index') }}" class="nav-link text-white menu-link">
        ⚠ Risk Score
    </a>
</li>
            @if(auth()->user()->role === 'admin')
<li>
    <a href="{{ route('admin.index') }}" class="nav-link text-white menu-link">
        ⚙ Admin
    </a>
</li>
@endif
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1">

        <!-- Topbar -->
        <div style="
background:rgba(15,23,42,0.95);
backdrop-filter:blur(16px);
border-bottom:1px solid rgba(56,189,248,0.35);
box-shadow:0 0 25px rgba(56,189,248,0.15);
" class="shadow-sm px-4 py-3 d-flex justify-content-between align-items-center">
            <div>
    <h3 style="
color:#38bdf8;
font-weight:700;
text-shadow:0 0 12px rgba(56,189,248,0.5);
margin:0;
">
    Global Supply Chain AI Dashboard
</h3>
<div style="
height:2px;
width:260px;
margin-top:6px;
background:linear-gradient(to right,#38bdf8,transparent);
box-shadow:0 0 12px #38bdf8;
"></div>
    <div class="top-glow-line mt-2"></div>
</div>

            <div class="d-flex align-items-center gap-3">
    
    <span id="liveClock" class="text-info fw-bold"></span>

    <span style="
        background:rgba(34,197,94,0.15);
        color:#86efac;
        padding:6px 12px;
        border-radius:999px;
        font-size:13px;
        border:1px solid rgba(34,197,94,0.3);
    ">
        ● System Online
    </span>

    <span>{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4" style="
background:rgba(255,255,255,0.02);
min-height:100vh;
">
    @yield('content')
</div>

    </div>
</div>

<script>
function updateClock(){
    const now = new Date();

    const time = now.toLocaleTimeString('en-GB');
    const date = now.toLocaleDateString('en-GB');

    document.getElementById('liveClock').innerHTML =
        date + ' | ' + time;
}

setInterval(updateClock,1000);
updateClock();
</script>
<script>
document.querySelectorAll('.counter').forEach(counter => {
    const target = +counter.getAttribute('data-target');
    let count = 0;

    const updateCounter = () => {
        const increment = Math.max(1, Math.ceil(target / 30));

        if (count < target) {
            count += increment;

            if (count > target) {
                count = target;
            }

            counter.innerText = count;
            setTimeout(updateCounter, 40);
        } else {
            counter.innerText = target;
        }
    };

    updateCounter();
});
</script>
</body>
</html>