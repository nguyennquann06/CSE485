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
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // id: Mã dự án
            $table->string('name'); // Tên dự án
            $table->date('start_date'); // Ngày bắt đầu
            $table->date('end_date')->nullable(); // Ngày kết thúc (có thể null)
            $table->unsignedBigInteger('budget'); // Ngân sách
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
