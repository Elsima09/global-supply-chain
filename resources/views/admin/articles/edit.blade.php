@extends('layouts.dashboard')

@section('content')

<h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
    Edit Article
</h2>

<div class="card futuristic-card border-0">
    <div class="card-body">

        <form action="{{ route('admin.articles.update', $article->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Title</label>
                <input
                    type="text"
                    name="title"
                    value="{{ $article->title }}"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Content</label>
                <textarea
                    name="content"
                    rows="8"
                    class="form-control"
                    required
                >{{ $article->content }}</textarea>
            </div>

            <button class="btn btn-warning">
                Update Article
            </button>

            <a href="{{ route('admin.articles') }}" class="btn btn-secondary">
                Back
            </a>
        </form>

    </div>
</div>

@endsection