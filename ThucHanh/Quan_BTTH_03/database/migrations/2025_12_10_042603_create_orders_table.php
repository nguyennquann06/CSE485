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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // id - primary key

            // FK tới customers.id
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->onDelete('cascade');

            $table->date('order_date');          // Ngày đặt hàng
            $table->decimal('total_price', 15, 2); // Tổng giá trị đơn hàng
            $table->string('status')->default('Pending'); // Trạng thái: Pending, Paid, Cancelled...

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
