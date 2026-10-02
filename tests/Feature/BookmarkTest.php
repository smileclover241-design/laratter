<?php

namespace Tests\Feature;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_bookmark_a_tweet(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tweet = Tweet::factory()->create();

        $this->post(route('tweets.bookmark', $tweet));

        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id,
        ]);
    }

    public function test_can_unbookmark_a_tweet(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tweet = Tweet::factory()->create();

        $user->bookmarks()->attach($tweet->id);

        $this->delete(route('tweets.unbookmark', $tweet));

        $this->assertDatabaseMissing('bookmarks', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id,
        ]);
    }

    public function test_can_display_bookmarked_tweets(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $bookmarkedTweet = Tweet::factory()->create();
        $user->bookmarks()->attach($bookmarkedTweet->id);

        $response = $this->get(route('bookmarks.index'));

        $response->assertStatus(200);
        $response->assertSee($bookmarkedTweet->tweet);
    }

    public function test_does_not_display_unbookmarked_tweets(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $bookmarkedTweet = Tweet::factory()->create();
        $user->bookmarks()->attach($bookmarkedTweet->id);

        $unbookmarkedTweet = Tweet::factory()->create();

        $response = $this->get(route('bookmarks.index'));

        $response->assertStatus(200);
        $response->assertSee($bookmarkedTweet->tweet);
        $response->assertDontSee($unbookmarkedTweet->tweet);
    }
}