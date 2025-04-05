<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class YouTubeController extends Controller
{
    public function index()
    {
        return view('youtube.index');
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $apiKey = env('YOUTUBE_API_KEY');

        $response = Http::get('https://www.googleapis.com/youtube/v3/search', [
            'q' => $keyword,
            'part' => 'snippet',
            'type' => 'video',
            'maxResults' => 5,
            'key' => $apiKey
        ]);

        $videos = collect($response->json()['items'])->map(function ($item) {
            return [
                'title' => $item['snippet']['title'],
                'videoId' => $item['id']['videoId'],
                'thumbnail' => $item['snippet']['thumbnails']['default']['url']
            ];
        });

        return view('youtube.results', compact('videos', 'keyword'));
    }

    public function getComments($videoId)
    {
        $apiKey = env('YOUTUBE_API_KEY');
        $response = Http::get('https://www.googleapis.com/youtube/v3/commentThreads', [
            'videoId' => $videoId,
            'part' => 'snippet',
            'maxResults' => 50,
            'textFormat' => 'plainText',
            'key' => $apiKey
        ]);

        $comments = collect($response->json()['items'])->map(function ($item) {
            return [
                'text' => $item['snippet']['topLevelComment']['snippet']['textDisplay'],
                'sentiment' => $this->analyze($item['snippet']['topLevelComment']['snippet']['textDisplay']),
            ];
        });

        return view('youtube.comments', compact('comments'));
    }

    // تحليل بسيط
    /* private function analyze($text)
    {
        $positive = ['جميل', 'ممتاز', 'رائع', 'جيد'];
        $negative = ['سيء', 'رديء', 'ممل', 'ضعيف'];

        $score = 0;
        foreach ($positive as $word) {
            if (str_contains($text, $word)) $score++;
        }
        foreach ($negative as $word) {
            if (str_contains($text, $word)) $score--;
        }

        return $score > 0 ? 'إيجابي' : ($score < 0 ? 'سلبي' : 'محايد');
    } */

    private function analyze($text)
{
    $apiKey = env('OPENAI_API_KEY');

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
    ])->post('https://api.openai.com/v1/chat/completions', [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'system', 'content' => 'أنت أداة لتحليل المشاعر. صنّف التعليق إلى: إيجابي، سلبي، أو محايد فقط.'],
            ['role' => 'user', 'content' => $text]
        ],
        'max_tokens' => 10,
        'temperature' => 0.2,
    ]);

    return trim($response->json()['choices'][0]['message']['content']);
}

}
