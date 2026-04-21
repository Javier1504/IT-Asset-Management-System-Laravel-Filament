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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();

            // manager yang mengajukan
            $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete();

            // karyawan/pegawai yang menjadi tujuan request
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();

            // manager yang bertanggung jawab/verifikator
            $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();

            // technician yang menangani maintenance
            $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete();

            $table->foreignId('asset_id')->nullable()->constrained('assets')->nullOnDelete();

            $table->string('title');
            $table->text('description');

            // priority tidak diisi manual user
            $table->string('priority')->default('medium');

            // flow final maintenance
            $table->string('status')->default('submitted_by_manager');
            // submitted_by_manager
            // assigned_to_technician
            // in_progress
            // completed_by_technician
            // signed_by_manager
            // received_by_employee
            // rejected
            // cancelled

            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            // tanda tangan berjenjang
            $table->timestamp('manager_signed_at')->nullable();
            $table->timestamp('employee_signed_at')->nullable();

            // catatan internal
            $table->text('manager_note')->nullable();
            $table->text('technician_note')->nullable();
            $table->text('completion_note')->nullable();

            $table->timestamps();

            $table->index(['ticket_number']);
            $table->index(['status']);
            $table->index(['priority']);
            $table->index(['requester_id']);
            $table->index(['employee_id']);
            $table->index(['manager_id']);
            $table->index(['technician_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};