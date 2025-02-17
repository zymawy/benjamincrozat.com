<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('image')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('introduction')->nullable();
            $table->text('content');
            $table->text('conclusion')->nullable();
            $table->text('description')->nullable();
            $table->boolean('promotes_affiliate_links')->default(false);
            $table->timestamps();
            $table->datetime('modified_at')->nullable();

            $table->fullText(['content', 'description']);
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('posts');
    }
};
