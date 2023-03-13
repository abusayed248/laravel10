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
        Schema::create('childcats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cat_id')->index();
            $table->unsignedBigInteger('subcat_id')->index();
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcat_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->string('childcat_name')->nullable();
            $table->string('childcat_slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('childcats');
    }
};
