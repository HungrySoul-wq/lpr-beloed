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
    Schema::create('tours', function (Blueprint $table) {
        $table->id();
        $table->foreignId('country_id')
            ->constrained('countries')
            ->restrictOnDelete();
        $table->string('title', 150);
        $table->date('start_date');
        $table->unsignedInteger('days');
        $table->decimal('price', 10, 2);
        $table->boolean('is_hot')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
