<?php

namespace App\Http\Controllers;

use App\Models\PositiveWord;
use App\Models\NegativeWord;
use App\Services\NewsService;
use App\Models\NewsCache;
use App\Models\SentimentResult;

class SentimentController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index()
    {
        $news = $this->newsService->getNews();
        $articles = $news['articles'] ?? [];

        $positiveWords = PositiveWord::pluck('word')->toArray();
        $negativeWords = NegativeWord::pluck('word')->toArray();

        $results = [];

        foreach ($articles as $article) {
            $news = NewsCache::firstOrCreate(
    ['title' => $article['title'] ?? ''],
    [
        'description' => $article['description'] ?? '',
        'source' => $article['source']['name'] ?? 'Unknown',
        'category' => 'Supply Chain',
        'sentiment' => 'Pending'
    ]
);

            $text = strtolower(
                ($article['title'] ?? '') . ' ' .
                ($article['description'] ?? '')
            );

            $positiveScore = 0;
            $negativeScore = 0;

            foreach ($positiveWords as $word) {
                if (str_contains($text, $word)) {
                    $positiveScore++;
                }
            }

            foreach ($negativeWords as $word) {
                if (str_contains($text, $word)) {
                    $negativeScore++;
                }
            }

            $score = $positiveScore - $negativeScore;

            if ($score > 0) {
                $sentiment = 'Positive';
            } elseif ($score < 0) {
                $sentiment = 'Negative';
            } else {
                $sentiment = 'Neutral';
            }
            $news->update([
    'sentiment' => $sentiment
]);

SentimentResult::create([
    'news_cache_id' => $news->id,
    'positive_score' => $positiveScore,
    'negative_score' => $negativeScore,
    'sentiment' => $sentiment
]);

            $results[] = [
                'title' => $article['title'],
                'score' => $score,
                'sentiment' => $sentiment
            ];
        }

        return view('sentiment.index', compact('results'));
    }
}