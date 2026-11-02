<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('orders', function (Blueprint $t) {
            $t->unsignedBigInteger('user_id')->nullable()->index();
            $t->string('stage')->nullable();       // null = baru dibayar, lalu processing | shipped | done
            $t->string('tracking_no')->nullable(); // no. resi (opsional)
        });
    }
    public function down(): void { Schema::table('orders', fn(Blueprint $t) => $t->dropColumn(['user_id', 'stage', 'tracking_no'])); }
};
