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
            $table->id('order_number'); // ID(номер) заказа
            $table->string('customer_fullname'); // ФИО покупателя
            $table->integer('quantity');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('product_id')->constrained();
            $table->string('status')->default('Новый');
            $table->text('comment'); // Комментарий покупателя
            $table->decimal('total_price'); // Итоговая цена
            $table->timestamps();
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
