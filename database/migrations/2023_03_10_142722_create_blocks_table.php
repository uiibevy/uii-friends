<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(config('friends.user_model', 'App\Models\User'), 'blocker_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(config('friends.user_model', 'App\Models\User'), 'blocked_id')->constrained()->cascadeOnDelete();
            $table->timestamp('blocked_at')->nullable();
            $table->timestamp('unblocked_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
