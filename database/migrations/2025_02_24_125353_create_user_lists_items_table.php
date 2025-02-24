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
        Schema::create('user_lists_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_list_id',)->references('id')->on('user_lists')->constrained()->cascadeOnDelete();
            $table->string('header', 100);
            $table->string('description', 500);
            $table->integer('status')->default(1);
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_lists_items');
    }
};
