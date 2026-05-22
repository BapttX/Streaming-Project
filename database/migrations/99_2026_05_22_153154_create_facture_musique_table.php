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
        Schema::create('facture_musique', function (Blueprint $table) {
            $table->foreignId('facture_id')->constrained()->cascadeOnDelete();
            $table->foreignId('musique_id')->constrained()->cascadeOnDelete();
            $table->primary(['facture_id', 'musique_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_musique');
    }
};
