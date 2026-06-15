<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('matrix_sub_teams', function (Blueprint $table) { $table->id(); $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete(); $table->string('code'); $table->string('name'); $table->boolean('is_active')->default(true); $table->timestamps(); $table->unique(['company_id','code']); });
        Schema::create('matrix_sub_team_members', function (Blueprint $table) { $table->id(); $table->foreignId('matrix_sub_team_id')->constrained()->cascadeOnDelete(); $table->foreignId('user_id')->constrained()->cascadeOnDelete(); $table->string('role_label')->nullable(); $table->boolean('is_leader')->default(false); $table->timestamps(); $table->unique(['matrix_sub_team_id','user_id']); });

        Schema::create('stock_opnames', function (Blueprint $table) { $table->id(); $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete(); $table->string('code')->unique(); $table->string('title'); $table->string('type')->default('multi_team'); $table->string('scope_type')->default('selected_users'); $table->string('status')->default('draft'); $table->date('start_date')->nullable(); $table->date('end_date')->nullable(); $table->foreignId('checked_by')->nullable()->constrained('users')->nullOnDelete(); $table->json('summary')->nullable(); $table->text('notes')->nullable(); $table->timestamp('completed_at')->nullable(); $table->timestamps(); });
        Schema::create('stock_opname_teams', function (Blueprint $table) { $table->id(); $table->foreignId('stock_opname_id')->constrained()->cascadeOnDelete(); $table->string('team'); $table->foreignId('matrix_sub_team_id')->nullable()->constrained()->nullOnDelete(); $table->timestamps(); $table->unique(['stock_opname_id','team','matrix_sub_team_id'], 'so_team_unique'); });
        Schema::create('stock_opname_users', function (Blueprint $table) { $table->id(); $table->foreignId('stock_opname_id')->constrained()->cascadeOnDelete(); $table->foreignId('stock_opname_team_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('user_id')->constrained()->cascadeOnDelete(); $table->string('team')->nullable(); $table->timestamps(); $table->unique(['stock_opname_id','user_id'], 'so_user_unique'); });
        Schema::create('stock_opname_items', function (Blueprint $table) {
            $table->id(); $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('stock_opname_id')->constrained()->cascadeOnDelete();
            $table->foreignId('end_user_asset_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('office_asset_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $table->string('asset_source')->default('end_user'); $table->string('snapshot_asset_number')->nullable(); $table->string('snapshot_asset_name')->nullable(); $table->string('snapshot_asset_brand')->nullable(); $table->string('snapshot_serial_number')->nullable(); $table->string('snapshot_user_name')->nullable(); $table->string('snapshot_user_role')->nullable(); $table->string('snapshot_location_name')->nullable();
            $table->string('result_status')->default('pending'); $table->string('physical_condition')->nullable(); $table->boolean('user_match')->default(true); $table->boolean('need_follow_up')->default(false); $table->string('issue_type')->nullable(); $table->dateTime('scheduled_at')->nullable(); $table->decimal('additional_budget',15,2)->nullable(); $table->text('follow_up_summary')->nullable(); $table->json('checklist_data')->nullable(); $table->text('notes')->nullable(); $table->dateTime('checked_at')->nullable(); $table->foreignId('checked_by')->nullable()->constrained('users')->nullOnDelete(); $table->timestamps();
        });
        Schema::create('stock_opname_checklist_templates', function (Blueprint $table) { $table->id(); $table->string('asset_category'); $table->string('label'); $table->string('key'); $table->boolean('is_required')->default(false); $table->boolean('is_active')->default(true); $table->timestamps(); $table->unique(['asset_category','key']); });

        Schema::create('internal_notes', function (Blueprint $table) { $table->id(); $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('stock_opname_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('stock_opname_item_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete(); $table->string('type')->default('note'); $table->string('priority')->default('normal'); $table->date('due_date')->nullable(); $table->string('status')->default('open'); $table->text('content'); $table->timestamps(); });
        Schema::create('comments', function (Blueprint $table) { $table->id(); $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); $table->morphs('commentable'); $table->text('body'); $table->timestamps(); });
        Schema::create('audit_trails', function (Blueprint $table) { $table->id(); $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); $table->string('event'); $table->string('module')->nullable(); $table->string('auditable_type')->nullable(); $table->unsignedBigInteger('auditable_id')->nullable(); $table->json('old_values')->nullable(); $table->json('new_values')->nullable(); $table->string('ip_address')->nullable(); $table->text('user_agent')->nullable(); $table->text('description')->nullable(); $table->timestamps(); });
    }
    public function down(): void
    {
        foreach (['audit_trails','comments','internal_notes','stock_opname_checklist_templates','stock_opname_items','stock_opname_users','stock_opname_teams','stock_opnames','matrix_sub_team_members','matrix_sub_teams'] as $table) Schema::dropIfExists($table);
    }
};
