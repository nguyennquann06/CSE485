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
        Schema::create('it_centers', function (Blueprint $table) {
            $table->id(); // id
            $table->string('name');           // tên trung tâm
            $table->string('location');       // địa điểm
            $table->string('contact_email');  // email liên hệ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('it_centers');
    }
};
