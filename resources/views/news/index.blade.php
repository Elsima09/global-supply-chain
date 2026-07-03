@extends('layouts.dashboard')

@section('content')

<div class="card futuristic-card border-0">

    <div class="card-body">

        <h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
    Global Logistics News
</h2>

        @forelse($articles as $article)

            <div class="card futuristic-card border-0 mb-3">

                <div class="card-body">

                    <h5>{{ $article['title'] }}</h5>

                    <small style="color:#94a3b8;">

                        {{ $article['source']['name'] }}

                        |

                        {{ \Carbon\Carbon::parse($article['publishedAt'])->format('d M Y H:i') }}

                    </small>

                    <p class="mt-2 text-white">

                        {{ $article['description'] }}

                    </p>

                    <a href="{{ $article['url'] }}"
                       target="_blank"
                       class="btn btn-sm"
style="
background:linear-gradient(90deg,#0ea5e9,#38bdf8);
border:none;
color:white;
box-shadow:0 0 15px rgba(56,189,248,0.35);
">

                        Read Article

                    </a>

                </div>

            </div>

        @empty

            <div class="alert alert-warning">

                No News Available

            </div>

        @endforelse

    </div>

</div>

@endsection