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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();                                   // id
            $table->string('brand');                        // hãng
            $table->string('model');                        // mẫu
            $table->text('specifications');                 // thông số
            $table->boolean('rental_status')->default(false); // true = đang cho thuê
            $table->unsignedBigInteger('renter_id')->nullable(); // FK

            $table->foreign('renter_id')
                  ->references('id')->on('renters')
                  ->onDelete('set null');                   // nếu xóa renter thì set null

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
