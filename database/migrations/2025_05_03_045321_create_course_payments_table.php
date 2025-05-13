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
        Schema::create('course_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_courses_id')->constrained()->onDelete('cascade');

            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->string('reference_no')->nullable();
            $table->enum('method', ['cash', 'card', 'upi', 'netbanking', 'other'])->default('cash');
            $table->enum('payment_by', ['admin', 'student', 'other'])->default('admin');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_payments');
    }
};
