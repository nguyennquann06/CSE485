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
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // id (PK)
            $table->string('title');                // Tên sách
            $table->string('author');               // Tác giả
            $table->year('publication_year');       // Năm xuất bản
            $table->string('genre');                // Thể loại

            // Khóa ngoại tới libraries.id
            $table->unsignedBigInteger('library_id');
            $table->foreign('library_id')
                  ->references('id')
                  ->on('libraries')
                  ->onDelete('cascade');

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
