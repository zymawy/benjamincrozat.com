<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        if (! app()->runningUnitTests()) {
            User::factory()->create([
                'name' => 'Benjamin Crozat',
                'email' => 'hello@benjamincrozat.com',
            ]);
        }
    }

    public function down() : void
    {
        Schema::dropIfExists('users');
    }
};
