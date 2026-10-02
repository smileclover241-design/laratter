<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    /** @use HasFactory<\Database\Factories\TweetFactory> */
    use HasFactory;

    protected $fillable = ['tweet'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    public function liked()
    {
        return $this->belongsToMany(User::class);
    }

    public function bookmarked()
    {
    return $this->belongsToMany(User::class, 'bookmarks');
    }
    
    public function scopeKeyword(Builder $query, ?string $keyword): Builder
    {
        return $query->when($keyword, function (Builder $query, string $keyword) {
            $query->where('tweet', 'like', '%' . $keyword . '%');
        });
    }

    public function scopeTimeline(Builder $query, User $user): Builder
    {
        return $query
            ->where('user_id', $user->id)
            ->orWhereIn('user_id', $user->follows->pluck('id'));
    }
}
