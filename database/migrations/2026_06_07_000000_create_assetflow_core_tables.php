<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) { $table->id(); $table->string('name'); $table->string('code')->unique(); $table->string('status')->default('active'); $table->timestamps(); });
        Schema::table('users', function (Blueprint $table) { $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete(); });

        Schema::create('locations', function (Blueprint $table) { $table->id(); $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete(); $table->string('name'); $table->string('code')->nullable(); $table->string('floor')->nullable(); $table->text('description')->nullable(); $table->timestamps(); });
        Schema::create('asset_types', function (Blueprint $table) { $table->id(); $table->string('name'); $table->string('category'); $table->string('depreciation_method')->nullable(); $table->unsignedInteger('useful_life_months')->nullable(); $table->timestamps(); });

        Schema::create('assets', function (Blueprint $table) {
            $table->id(); $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('asset_type_id')->constrained()->cascadeOnDelete();
            $table->string('asset_number')->unique(); $table->string('name'); $table->string('brand')->nullable(); $table->string('model')->nullable(); $table->string('serial_number')->nullable();
            $table->text('specification')->nullable(); $table->date('purchase_date')->nullable(); $table->decimal('purchase_price', 15, 2)->default(0); $table->date('cut_off_date')->nullable();
            $table->string('condition')->default('good'); $table->string('status')->default('stock'); $table->text('notes')->nullable(); $table->string('image_path')->nullable();
            $table->timestamps(); $table->softDeletes();
        });

        Schema::create('end_user_assets', function (Blueprint $table) { $table->id(); $table->foreignId('asset_id')->constrained()->cascadeOnDelete(); $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); $table->string('classification')->nullable(); $table->string('previous_status')->nullable(); $table->timestamps(); $table->softDeletes(); });
        Schema::create('office_assets', function (Blueprint $table) { $table->id(); $table->foreignId('asset_id')->constrained()->cascadeOnDelete(); $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete(); $table->string('previous_status')->nullable(); $table->timestamps(); $table->softDeletes(); });
        Schema::create('physical_host_assets', function (Blueprint $table) { $table->id(); $table->foreignId('asset_id')->constrained()->cascadeOnDelete(); $table->string('hostname')->nullable(); $table->string('ip_address')->nullable(); $table->string('os')->nullable(); $table->timestamps(); });
        Schema::create('network_assets', function (Blueprint $table) { $table->id(); $table->foreignId('asset_id')->constrained()->cascadeOnDelete(); $table->string('ip_address')->nullable(); $table->string('mac_address')->nullable(); $table->string('network_role')->nullable(); $table->timestamps(); });
        Schema::create('security_peripherals', function (Blueprint $table) { $table->id(); $table->foreignId('asset_id')->constrained()->cascadeOnDelete(); $table->string('peripheral_type')->nullable(); $table->string('placement')->nullable(); $table->timestamps(); });

        Schema::create('sparepart_types', function (Blueprint $table) { $table->id(); $table->string('name')->unique(); $table->string('category')->default('sparepart'); $table->timestamps(); });
        Schema::create('spareparts', function (Blueprint $table) { $table->id(); $table->foreignId('sparepart_type_id')->constrained()->cascadeOnDelete(); $table->string('name'); $table->integer('stock')->default(0); $table->integer('minimum_stock')->default(0); $table->timestamps(); });
        Schema::create('sparepart_movements', function (Blueprint $table) { $table->id(); $table->foreignId('sparepart_id')->constrained()->cascadeOnDelete(); $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); $table->string('type'); $table->integer('quantity'); $table->text('notes')->nullable(); $table->timestamps(); });
    }
    public function down(): void
    {
        foreach (['sparepart_movements','spareparts','sparepart_types','security_peripherals','network_assets','physical_host_assets','office_assets','end_user_assets','assets','asset_types','locations'] as $table) Schema::dropIfExists($table);
        Schema::table('users', fn (Blueprint $table) => $table->dropForeign(['company_id']));
        Schema::dropIfExists('companies');
    }
};
