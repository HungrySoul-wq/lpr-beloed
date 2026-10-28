<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extra_tour', function (Blueprint $table) {
            $table->foreignId('extra_id')
                ->constrained('extras')
                ->cascadeOnDelete();

            $table->foreignId('tour_id')
                ->constrained('tours')
                ->cascadeOnDelete();

            $table->primary(['extra_id', 'tour_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extra_tour');
    }
};