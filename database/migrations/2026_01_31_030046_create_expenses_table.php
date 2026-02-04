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
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->date('date');
            $table->unsignedTinyInteger('month');
            $table->year('year');
            $table->enum('type', ['income', 'expense']);
            $table->longText('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->boolean('is_installment')->default(false);
            $table->unsignedTinyInteger('current_installment')->nullable();
            $table->unsignedTinyInteger('total_installments')->nullable();
            $table->uuid('installments_group')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
