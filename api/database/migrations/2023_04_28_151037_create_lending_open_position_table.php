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
        Schema::create('lending_open_position', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('paper');
            $table->string('asset_role');
            $table->string('balance_amount');
            $table->string('average_price');
            $table->string('price_factor');
            $table->string('total_balance');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lending_open_position');
    }
};
