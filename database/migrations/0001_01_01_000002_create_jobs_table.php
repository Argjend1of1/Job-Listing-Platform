<?php

use App\Models\Category;
use App\Models\Employer;
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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Category::class);
            $table->string('title');
            $table->string('salary');
            $table->text('about');
            $table->boolean('top')->default(false);
            $table->string('location');
            $table->enum('schedule', ['Full Time', 'Part Time'])->default('Full Time');
            $table->string('url');
            $table->timestamps();
        });

        //add expiring date? - stop listing the job after it expires.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
