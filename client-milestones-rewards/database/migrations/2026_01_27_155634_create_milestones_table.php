<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "6 Months with Oshara"
            $table->string('type'); // e.g. "time"
            $table->string('trigger_condition'); // e.g. "months:6"
            $table->foreignId('reward_id')->nullable()->constrained('rewards')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('milestones');
    }
};
