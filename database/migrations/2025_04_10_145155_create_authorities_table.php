<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('authorities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('code')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('authorities')->insert(
            [
                [
                    'name' => 'show',
                    'code' => 1
                ],
                [
                    'name' => 'update',
                    'code' => 2
                ],
                [
                    'name' => 'delete',
                    'code' => 3
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authorities');
    }
};
