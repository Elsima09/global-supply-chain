@extends('layouts.dashboard')

@section('content')

<div class="card futuristic-card border-0">
    <div class="card-body">

        <h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
            News Sentiment Analysis
        </h2>

        <table class="table table-bordered table-hover align-middle futuristic-table">

            <thead>
                <tr>
                    <th>News Title</th>
                    <th>Score</th>
                    <th>Sentiment</th>
                </tr>
            </thead>

            <tbody>

            @foreach($results as $item)
                <tr>
                    <td>{{ $item['title'] }}</td>

                    <td>
                        <span style="color:#67e8f9;font-weight:600;">
                            {{ $item['score'] }}
                        </span>
                    </td>

                    <td>
                        @if($item['sentiment'] == 'Positive')
                            <span class="badge bg-success">Positive</span>
                        @elseif($item['sentiment'] == 'Negative')
                            <span class="badge bg-danger">Negative</span>
                        @else
                            <span class="badge bg-secondary">Neutral</span>
                        @endif
                    </td>
                </tr>
            @endforeach

            </tbody>

        </table>

    </div>
</div>

@endsection