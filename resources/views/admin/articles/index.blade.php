@extends('layouts.dashboard')

@section('content')

<h2 class="mb-4" style="color:#38bdf8; text-shadow:0 0 12px #38bdf8;">
    Manage Articles
</h2>

<div class="card futuristic-card border-0">
    <div class="card-body">

        <form action="{{ route('admin.articles.store') }}" method="POST" class="mb-4">
    @csrf

    <div class="mb-3">
        <input type="text" name="title" class="form-control" placeholder="Article Title" required>
    </div>

    <div class="mb-3">
        <textarea name="content" class="form-control" rows="4"
            placeholder="Article Content..." required></textarea>
    </div>

    <button class="btn btn-info">
        Add Article
    </button>
</form>

        <table class="table table-bordered table-hover futuristic-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>User ID</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ Str::limit($article->content, 50) }}</td>
                    <td>{{ $article->user_id }}</td>
                    <td>
                        <a href="{{ route('admin.articles.edit', $article->id) }}"
   class="btn btn-warning btn-sm">
    Edit
</a>

                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')

    <button class="btn btn-danger btn-sm"
        onclick="return confirm('Delete this article?')">
        Delete
    </button>
</form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection