<?php

namespace App\Models;

use App\Models\Posts\Post;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Affiliate extends BaseModel
{
    public function posts() : BelongsToMany
    {
        return $this->belongsToMany(Post::class)->withPivot('position');
    }

    public function renderedHighlightText() : Attribute
    {
        return Attribute::make(
            fn () => str($this->highlight_text ?? '')->marxdown()
        )->shouldCache();
    }

    public function renderedTake() : Attribute
    {
        return Attribute::make(
            fn () => str($this->take ?? '')->marxdown()
        )->shouldCache();
    }

    public function renderedPricing() : Attribute
    {
        return Attribute::make(
            fn () => str($this->pricing ?? '')->marxdown()
        )->shouldCache();
    }

    public function renderedContent() : Attribute
    {
        return Attribute::make(
            fn () => str($this->content ?? '')->marxdown()
        )->shouldCache();
    }

    public function renderedKeyFeatures() : Attribute
    {
        return Attribute::make(
            fn () => str($this->key_features ?? '')->marxdown()
        )->shouldCache();
    }

    public function renderedPros() : Attribute
    {
        return Attribute::make(
            fn () => str($this->pros ?? '')->marxdown()
        )->shouldCache();
    }

    public function renderedCons() : Attribute
    {
        return Attribute::make(
            fn () => str($this->cons ?? '')->marxdown()
        )->shouldCache();
    }
}
