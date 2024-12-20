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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_Name');
            $table->text('description');
            $table->double('price');
            $table->integer('stock');
            $table->integer('availableCon');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        DB::table('products')->insert([
            [
                'product_Name' => 'Container',
                'description' => '4L',
                'price' => '25', // Add a valid location
                'stock' => '100',
                'availableCon' => '100',
                'image_url' => 'container',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('products')->insert([
            [
                'product_Name' => 'Gallon',
                'description' => '4L',
                'price' => '25', // Add a valid location
                'stock' => '100',
                'availableCon' => '100',
                'image_url' => 'galoon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('products')->insert([
            [
                'product_Name' => 'Water Bottle',
                'description' => '400ml',
                'price' => '10',
                'stock' => '100',
                'availableCon' => '100',
                'image_url' => 'bottle',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
