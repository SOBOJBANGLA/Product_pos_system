<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('sku')->unique();
                $table->string('unit');
                $table->string('unit_value');
                $table->decimal('selling_price', 10, 2)->nullable();
                $table->decimal('purchase_price', 10, 2)->nullable();
                $table->decimal('discount', 5, 2)->default(0);
                $table->decimal('tax', 5, 2)->default(0);
                $table->string('image')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}; 