<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TwitterService;

class TwitterController extends Controller
{
    protected $twitterService;

    public function __construct(TwitterService $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    public function fetchTweets(Request $request)
    {
        $keyword = $request->input('keyword', 'london'); // الكلمة المفتاحية للبحث
        $tweets = $this->twitterService->searchTweets($keyword, 10);

        return response()->json($tweets);
    }
}
