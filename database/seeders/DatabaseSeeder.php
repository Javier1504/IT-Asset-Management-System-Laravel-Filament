<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetRequest;
use App\Models\AssetType;
use App\Models\Company;
use App\Models\EndUserAsset;
use App\Models\Location;
use App\Models\MatrixSubTeam;
use App\Models\MatrixSubTeamMember;
use App\Models\OfficeAsset;
use App\Models\StockOpname;
use App\Models\StockOpnameChecklistTemplate;
use App\Models\StockOpnameUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::firstOrCreate(
            ['code' => 'DEMO'],
            ['name' => 'Demo Organization', 'status' => 'active']
        );

        $admin = User::firstOrCreate(
            ['email' => 'admin@assetflow.local'],
            ['company_id' => $company->id, 'name' => 'System Admin', 'password' => Hash::make('password'), 'role' => 'super_admin', 'status' => 'active', 'team' => 'IT', 'job_title' => 'Admin Aset', 'job_family' => 'IT']
        );

        $manager = User::firstOrCreate(
            ['email' => 'manager@assetflow.local'],
            ['company_id' => $company->id, 'name' => 'Manager Unit', 'password' => Hash::make('password'), 'role' => 'manager', 'status' => 'active', 'team' => 'IT', 'job_title' => 'Manager', 'job_family' => 'IT']
        );

        $employee = User::firstOrCreate(
            ['email' => 'user@assetflow.local'],
            ['company_id' => $company->id, 'name' => 'Pegawai Demo', 'password' => Hash::make('password'), 'role' => 'employee', 'status' => 'active', 'team' => 'Operations', 'job_title' => 'Officer', 'job_family' => 'Operations']
        );

        $loc = Location::firstOrCreate(
            ['company_id' => $company->id, 'name' => 'Head Office - Floor 1'],
            ['code' => 'HO-1', 'floor' => '1']
        );

        $laptopType = AssetType::firstOrCreate(['name' => 'Laptop'], ['category' => 'end_user', 'useful_life_months' => 48]);
        $chairType = AssetType::firstOrCreate(['name' => 'Office Chair'], ['category' => 'office', 'useful_life_months' => 60]);

        $asset1 = Asset::firstOrCreate(
            ['asset_number' => 'AST-0001'],
            ['company_id' => $company->id, 'asset_type_id' => $laptopType->id, 'name' => 'Laptop Developer', 'brand' => 'Generic', 'serial_number' => 'SN-0001', 'purchase_price' => 12000000, 'status' => 'used']
        );

        $asset2 = Asset::firstOrCreate(
            ['asset_number' => 'AST-0002'],
            ['company_id' => $company->id, 'asset_type_id' => $chairType->id, 'name' => 'Ergonomic Chair', 'brand' => 'Generic', 'purchase_price' => 1500000, 'status' => 'used']
        );

        EndUserAsset::firstOrCreate(['asset_id' => $asset1->id], ['user_id' => $employee->id, 'classification' => 'standard']);
        OfficeAsset::firstOrCreate(['asset_id' => $asset2->id], ['location_id' => $loc->id]);

        AssetRequest::firstOrCreate(
            ['title' => 'Permintaan laptop operasional', 'requested_by' => $employee->id],
            ['company_id' => $company->id, 'target_user_id' => $employee->id, 'request_type' => 'new', 'requested_at' => now(), 'asset_type_id' => $laptopType->id, 'desired_asset' => 'Laptop kerja', 'reason' => 'Kebutuhan perangkat kerja pegawai.', 'status' => 'pending']
        );

        $sub = MatrixSubTeam::firstOrCreate(['company_id' => $company->id, 'code' => 'MTR-A'], ['name' => 'Matrix Team A', 'is_active' => true]);
        MatrixSubTeamMember::firstOrCreate(['matrix_sub_team_id' => $sub->id, 'user_id' => $manager->id], ['role_label' => 'Team Leader', 'is_leader' => true]);
        MatrixSubTeamMember::firstOrCreate(['matrix_sub_team_id' => $sub->id, 'user_id' => $employee->id], ['role_label' => 'Member', 'is_leader' => false]);

        $opname = StockOpname::firstOrCreate(
            ['title' => 'Stock Opname Demo'],
            ['company_id' => $company->id, 'type' => 'multi_team', 'scope_type' => 'selected_users', 'status' => 'draft', 'start_date' => now()->toDateString(), 'checked_by' => $manager->id]
        );
        StockOpnameUser::firstOrCreate(['stock_opname_id' => $opname->id, 'user_id' => $employee->id], ['team' => $employee->team]);

        foreach ([
            ['end_user', 'Adaptor daya tersedia', 'power_adapter'],
            ['end_user', 'Kondisi layar baik', 'screen_condition'],
            ['end_user', 'Kondisi keyboard baik', 'keyboard_condition'],
            ['office', 'Kondisi fisik baik', 'physical_condition'],
            ['office', 'Lokasi sesuai', 'location_match'],
        ] as [$cat, $label, $key]) {
            StockOpnameChecklistTemplate::firstOrCreate(
                ['asset_category' => $cat, 'key' => $key],
                ['label' => $label, 'is_required' => true, 'is_active' => true]
            );
        }
    }
}
