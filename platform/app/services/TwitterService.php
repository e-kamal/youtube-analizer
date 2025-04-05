<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TwitterService
{
    private $bearerToken;

    public function __construct()
    {
        $this->bearerToken = env('TWITTER_BEARER_TOKEN');
    }

    public function searchTweets($query, $maxResults = 10)
    {
        $url = "https://api.twitter.com/2/tweets/search/recent?query={$query}&max_results={$maxResults}&tweet.fields=created_at,lang,geo";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->bearerToken}",
        ])->get($url);

        return $response->json();
        $tweets = $response->json();
        $formattedTweets = [];
        if (isset($tweets['data'])) {
            foreach ($tweets['data'] as $tweet) {
                $formattedTweets[] = [
                    'id' => $tweet['id'],
                    'author_id' => $tweet['author_id'],
                    'text' => $tweet['text'],
                    'created_at' => $tweet['created_at'],
                ];
            }
        }

        //return $formattedTweets;
    }
}
