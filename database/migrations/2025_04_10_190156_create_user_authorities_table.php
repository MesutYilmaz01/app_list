<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_authorities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_user_id')->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->foreignId('authorized_user_id')->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->foreignId('user_list_id')->references('id')->on('user_lists')->constrained()->cascadeOnDelete();
            $table->foreignId('authority_id')->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_authorities');
    }
};
