<?php

namespace App\Models\Posts\Concerns;

use Spatie\Feed\FeedItem;
use Illuminate\Support\Collection;

trait HasFeedItems
{
    public static function getFeedItems() : Collection
    {
        return self::query()
            ->latest()
            ->withUser()
            ->limit(10)
            ->get();
    }

    public function toFeedItem() : FeedItem
    {
        return FeedItem::create([
            'id' => route('posts.show', $this),
            'title' => $this->title,
            'summary' => $this->rendered_teaser ?? $this->description,
            'updated' => $this->created_at,
            'link' => route('posts.show', $this),
            'authorName' => $this->user_name ?? $this->user->name,
        ]);
    }
}
