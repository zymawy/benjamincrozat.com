<?php

namespace Database\Seeders;

use App\Models\Deal;
use App\Models\Post;
use App\Models\User;
use App\Models\Feature;
use App\Models\Category;
use App\Models\Redirect;
use App\Models\Affiliate;
use App\Models\Highlight;
use App\Models\Subscriber;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run() : void
    {
        User::factory()->create([
            'name' => 'Benjamin Crozat',
            'email' => 'benjamincrozat@me.com',
        ]);

        Post::factory(50)->create();

        Highlight::factory(10)->create();

        Affiliate::factory(10)->create();

        Feature::factory(100)->create();

        Category::factory(10)->create();

        Deal::factory(10)->withCategory()->create();

        Redirect::factory(10)->create();

        Subscriber::factory(50)->create();
    }
}
