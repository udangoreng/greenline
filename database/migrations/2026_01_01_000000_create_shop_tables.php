<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('latin');
            $t->string('type');
            $t->unsignedInteger('price');
            $t->unsignedInteger('co2');
            $t->unsignedInteger('stock')->default(100);
            $t->text('description');
            $t->timestamps();
        });
        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->string('code')->unique();
            $t->string('name');
            $t->string('email');
            $t->string('phone');
            $t->text('address');
            $t->unsignedInteger('total');
            $t->string('status')->default('pending');
            $t->string('snap_token')->nullable();
            $t->timestamps();
        });
        Schema::create('order_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->constrained();
            $t->string('name');
            $t->unsignedInteger('price');
            $t->unsignedInteger('qty');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
    }
};
