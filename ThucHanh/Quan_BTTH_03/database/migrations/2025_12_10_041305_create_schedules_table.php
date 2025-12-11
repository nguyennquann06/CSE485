<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id(); // id (PK)

            // FK classroom_id tham chiếu classrooms.id
            $table->unsignedBigInteger('classroom_id');

            $table->string('course_name');  // Tên môn học
            $table->string('day_of_week');  // Thứ trong tuần
            $table->string('time_slot');    // Thời gian

            $table->timestamps();

            // Ràng buộc khóa ngoại
            $table->foreign('classroom_id')
                  ->references('id')->on('classrooms')
                  ->onDelete('cascade');  // Nếu xóa phòng → xóa luôn lịch học
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
