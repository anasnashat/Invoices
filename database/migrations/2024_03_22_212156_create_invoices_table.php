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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoices_number');
            $table->date('invoices_date');
            $table->date('due_date');
            $table->foreignId('product_id')->constrained('products')->noActionOnDelete();
            $table->foreignId('section_id')->constrained('sections')->noActionOnDelete();
            $table->string('rate_value');
            $table->decimal('value_vat',8,2);
            $table->decimal('total',8,2);
            $table->enum('status',[0,1,2]);
            $table->text('not');
            $table->foreignId('user_id')->constrained('users')->noActionOnDelete();
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
