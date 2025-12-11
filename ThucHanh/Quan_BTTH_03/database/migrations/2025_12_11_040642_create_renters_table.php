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
        Schema::create('renters', function (Blueprint $table) {
            $table->id();                                   // id
            $table->string('name');                         // tên người thuê
            $table->string('phone_number', 20);             // số điện thoại
            $table->string('email')->unique();              // email
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renters');
    }
};
