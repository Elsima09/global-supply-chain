<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class AdminArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();

        return view('admin.articles.index', compact('articles'));
    }

    public function store(Request $request)
{
    Article::create([
        'title' => $request->title,
        'content' => $request->content,
        'user_id' => auth()->id()
    ]);

    return redirect()->back()->with(
        'success',
        'Article added successfully!'
    );
}

public function destroy(Article $article)
{
    $article->delete();

    return redirect()->back()->with(
        'success',
        'Article deleted successfully!'
    );
}

public function edit(Article $article)
{
    return view('admin.articles.edit', compact('article'));
}

public function update(Request $request, Article $article)
{
    $article->update([
        'title' => $request->title,
        'content' => $request->content
    ]);

    return redirect()
        ->route('admin.articles')
        ->with('success', 'Article updated successfully!');
}

}