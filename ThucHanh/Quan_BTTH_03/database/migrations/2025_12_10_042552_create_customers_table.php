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
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // id - primary key
            $table->string('name'); // Tên khách hàng
            $table->string('email')->unique(); // Email (duy nhất)
            $table->string('phone', 20)->nullable(); // Số điện thoại
            $table->timestamps(); // created_at, updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
