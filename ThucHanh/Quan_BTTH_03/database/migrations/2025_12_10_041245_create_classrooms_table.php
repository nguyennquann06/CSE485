<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id(); // id (PK)
            $table->string('room_number'); // Số phòng: A101
            $table->integer('capacity');   // Sức chứa
            $table->string('building');    // Tòa nhà: Tòa nhà A
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('classrooms');
    }
};
