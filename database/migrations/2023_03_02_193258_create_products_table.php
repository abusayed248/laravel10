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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cat_id')->index();
            $table->unsignedBigInteger('subcat_id')->index();
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcat_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->integer('childcat_id')->nullable();
            $table->integer('admin_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('pickup_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->string('p_name')->nullable();
            $table->string('p_slug')->nullable();
            $table->string('p_code')->nullable();
            $table->string('unit')->nullable();
            $table->string('tags')->nullable();
            $table->string('colors')->nullable();
            $table->string('size')->nullable();
            $table->integer('stock_qty')->nullable()->default(0);
            $table->string('purchage_price')->nullable();
            $table->string('regular_price')->nullable();
            $table->string('discount_price')->nullable();
            $table->longText('description')->nullable();
            $table->string('video')->nullable();
            $table->string('p_view')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('images')->nullable();
            $table->boolean('status')->nullable()->default(0);
            $table->boolean('slider')->nullable()->default(0);
            $table->boolean('trendy')->nullable()->default(0);
            $table->boolean('featured')->nullable()->default(0);
            $table->boolean('today_deal')->nullable()->default(0);
            $table->dateTime('date_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
