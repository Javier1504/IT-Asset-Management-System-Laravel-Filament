<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asset_requests', function (Blueprint $table) {
            $table->id(); $table->string('ticket_code')->nullable()->unique(); $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete(); $table->foreignId('target_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('request_type'); $table->string('title'); $table->dateTime('requested_at')->nullable(); $table->foreignId('asset_type_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();
            $table->string('desired_asset')->nullable(); $table->text('reason'); $table->json('attachments')->nullable(); $table->string('status')->default('pending'); $table->text('admin_notes')->nullable(); $table->timestamps();
        });

        Schema::create('asset_maintenances', function (Blueprint $table) {
            $table->id(); $table->string('ticket_code')->nullable()->unique(); $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete(); $table->string('form_number')->unique(); $table->date('letter_date')->nullable(); $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete(); $table->foreignId('holder_id')->nullable()->constrained('users')->nullOnDelete(); $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->json('maintenance_types')->nullable(); $table->string('device_type')->nullable(); $table->string('repair_status')->default('on_progress'); $table->dateTime('started_at')->nullable(); $table->dateTime('finished_at')->nullable();
            $table->boolean('missing_data')->default(false); $table->string('backup_data')->nullable(); $table->text('problem_description'); $table->text('solution')->nullable(); $table->text('notes')->nullable(); $table->string('sparepart_requirement')->nullable(); $table->timestamps();
        });

        Schema::create('asset_installations', function (Blueprint $table) { $table->id(); $table->string('ticket_code')->nullable()->unique(); $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('asset_id')->constrained()->cascadeOnDelete(); $table->foreignId('installed_for')->nullable()->constrained('users')->nullOnDelete(); $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete(); $table->date('installed_at')->nullable(); $table->string('status')->default('installed'); $table->text('notes')->nullable(); $table->timestamps(); });

        Schema::create('asset_disposals', function (Blueprint $table) { $table->id(); $table->string('ticket_code')->nullable()->unique(); $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete(); $table->string('document_number')->unique(); $table->string('method')->nullable(); $table->date('disposal_date'); $table->string('location')->nullable(); $table->string('status')->default('pending'); $table->text('notes')->nullable(); $table->timestamps(); $table->softDeletes(); });
        Schema::create('asset_disposal_items', function (Blueprint $table) { $table->id(); $table->foreignId('asset_disposal_id')->constrained()->cascadeOnDelete(); $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('sparepart_id')->nullable()->constrained()->nullOnDelete(); $table->integer('quantity')->default(1); $table->string('manual_type')->nullable(); $table->string('manual_brand')->nullable(); $table->string('manual_number')->nullable(); $table->text('notes')->nullable(); $table->timestamps(); });

        Schema::create('software_licenses', function (Blueprint $table) { $table->id(); $table->string('ticket_code')->nullable()->unique(); $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete(); $table->string('software_name'); $table->string('category')->nullable(); $table->string('vendor_name')->nullable(); $table->string('license_type')->nullable(); $table->string('license_key')->nullable(); $table->integer('total_license')->default(1); $table->integer('used_license')->default(0); $table->date('purchase_date')->nullable(); $table->date('start_date')->nullable(); $table->date('expired_date')->nullable(); $table->date('renewal_reminder_date')->nullable(); $table->foreignId('pic_user_id')->nullable()->constrained('users')->nullOnDelete(); $table->string('status')->default('active'); $table->text('notes')->nullable(); $table->timestamps(); $table->softDeletes(); });

        Schema::create('vendors', function (Blueprint $table) { $table->id(); $table->string('ticket_code')->nullable()->unique(); $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete(); $table->string('name'); $table->string('pic_name')->nullable(); $table->string('email')->nullable(); $table->string('phone')->nullable(); $table->text('address')->nullable(); $table->string('category')->nullable(); $table->string('status')->default('active'); $table->text('notes')->nullable(); $table->timestamps(); $table->softDeletes(); });
        Schema::create('asset_offer_requests', function (Blueprint $table) { $table->id(); $table->string('ticket_code')->nullable()->unique(); $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete(); $table->string('request_number')->nullable()->unique(); $table->string('item_name'); $table->string('item_category')->nullable(); $table->text('required_specification')->nullable(); $table->integer('quantity')->default(1); $table->decimal('estimated_unit_budget',15,2)->nullable(); $table->decimal('estimated_total_budget',15,2)->nullable(); $table->date('needed_date')->nullable(); $table->foreignId('pic_user_id')->nullable()->constrained('users')->nullOnDelete(); $table->string('status')->default('open'); $table->text('notes')->nullable(); $table->timestamps(); $table->softDeletes(); });
        Schema::create('vendor_offers', function (Blueprint $table) { $table->id(); $table->foreignId('asset_offer_request_id')->constrained()->cascadeOnDelete(); $table->foreignId('vendor_id')->nullable()->constrained()->nullOnDelete(); $table->string('vendor_name')->nullable(); $table->string('offer_number')->nullable(); $table->date('offer_date')->nullable(); $table->date('valid_until')->nullable(); $table->decimal('unit_price',15,2)->default(0); $table->decimal('total_price',15,2)->default(0); $table->string('warranty')->nullable(); $table->string('delivery_estimation')->nullable(); $table->string('document_path')->nullable(); $table->string('status')->default('submitted'); $table->text('notes')->nullable(); $table->timestamps(); $table->softDeletes(); });
    }
    public function down(): void
    {
        foreach (['vendor_offers','asset_offer_requests','vendors','software_licenses','asset_disposal_items','asset_disposals','asset_installations','asset_maintenances','asset_requests'] as $table) Schema::dropIfExists($table);
    }
};
