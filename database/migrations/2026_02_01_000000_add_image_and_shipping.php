<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('products', fn(Blueprint $t) => $t->string('image')->nullable());
        Schema::table('orders', function (Blueprint $t) { $t->string('zone')->nullable(); $t->unsignedInteger('shipping')->default(0); });
    }
    public function down(): void {
        Schema::table('products', fn(Blueprint $t) => $t->dropColumn('image'));
        Schema::table('orders', fn(Blueprint $t) => $t->dropColumn(['zone', 'shipping']));
    }
};
