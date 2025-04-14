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
            $table->integer('code')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        $this->seed();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authorities');
    }

    /**
     * Creates initial data for this table.
     */
    private function seed(): void
    {
        DB::table('authorities')->insert(
            [
                [
                    'code' => 1
                ],
                [
                    'code' => 2
                ],
                [
                    'code' => 4
                ],
                [
                    'code' => 8
                ]
            ]
        );
    }
};
