<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

class BookmarkController extends Controller
{
    /**
     * 保存したツイート一覧
     */
    public function index()
    {
        $tweets = auth()->user()
            ->bookmarks()
            ->latest()
            ->paginate(10);

        return view('bookmarks.index', compact('tweets'));
    }

    /**
     * ブックマークする
     */
    public function store(Tweet $tweet)
    {
        auth()->user()->bookmarks()->syncWithoutDetaching($tweet->id);

        return back();
    }

    /**
     * ブックマークを解除する
     */
    public function destroy(Tweet $tweet)
    {
        auth()->user()->bookmarks()->detach($tweet->id);

        return back();
    }
}