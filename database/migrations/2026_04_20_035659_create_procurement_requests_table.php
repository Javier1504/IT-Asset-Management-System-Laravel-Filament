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
        Schema::create('procurement_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique();

            // manager yang mengajukan
            $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete();

            // karyawan yang menjadi tujuan request
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();

            // manager penanggung jawab
            $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();

            // finance yang menangani pengadaan
            $table->foreignId('finance_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('item_name');
            $table->string('category')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('unit')->default('pcs');

            $table->decimal('estimated_price', 15, 2)->nullable();
            $table->decimal('approved_price', 15, 2)->nullable();

            $table->text('purpose');
            $table->text('specification')->nullable();

            $table->string('priority')->default('medium');

            // flow final procurement
            $table->string('status')->default('submitted_by_manager');
            // submitted_by_manager
            // assigned_to_finance
            // in_review
            // approved_by_finance
            // rejected_by_finance
            // completed_by_finance
            // signed_by_manager
            // received_by_employee
            // cancelled

            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('finance_assigned_at')->nullable();
            $table->timestamp('finance_reviewed_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            // tanda tangan berjenjang
            $table->timestamp('manager_signed_at')->nullable();
            $table->timestamp('employee_signed_at')->nullable();

            // catatan internal
            $table->text('manager_note')->nullable();
            $table->text('finance_note')->nullable();
            $table->text('completion_note')->nullable();

            $table->timestamps();

            $table->index(['request_number']);
            $table->index(['status']);
            $table->index(['priority']);
            $table->index(['requester_id']);
            $table->index(['employee_id']);
            $table->index(['manager_id']);
            $table->index(['finance_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_requests');
    }
};