<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Company;
use App\Models\EndUserAsset;
use App\Models\Location;
use App\Models\OfficeAsset;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoStockOpnameAssetSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::query()->firstOrCreate(
            ['code' => 'DEMO'],
            ['name' => 'Demo Organization', 'status' => 'active']
        );

        $users = [
            'admin@assetflow.local' => [
                'name' => 'System Admin',
                'role' => 'super_admin',
                'team' => 'IT',
                'job_title' => 'System Admin',
            ],
            'manager@assetflow.local' => [
                'name' => 'IT Manager',
                'role' => 'manager',
                'team' => 'IT',
                'job_title' => 'Manager',
            ],
            'employee@assetflow.local' => [
                'name' => 'Demo Employee',
                'role' => 'employee',
                'team' => 'Operations',
                'job_title' => 'Operations Staff',
            ],
            'ops.lead@assetflow.local' => [
                'name' => 'Operations Lead',
                'role' => 'manager',
                'team' => 'Operations',
                'job_title' => 'Operations Lead',
            ],
            'finance.staff@assetflow.local' => [
                'name' => 'Finance Staff',
                'role' => 'employee',
                'team' => 'Finance',
                'job_title' => 'Finance Staff',
            ],
        ];

        foreach ($users as $email => $data) {
            User::query()->updateOrCreate(
                ['email' => $email],
                [
                    'company_id' => $company->id,
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => $data['role'],
                    'status' => 'active',
                    'team' => $data['team'],
                    'job_title' => $data['job_title'],
                ]
            );
        }

        $types = [
            'Laptop' => ['category' => 'end_user', 'useful_life_months' => 48],
            'Handphone' => ['category' => 'end_user', 'useful_life_months' => 36],
            'Monitor' => ['category' => 'office', 'useful_life_months' => 60],
            'Office Chair' => ['category' => 'office', 'useful_life_months' => 60],
            'Printer' => ['category' => 'office', 'useful_life_months' => 60],
        ];

        foreach ($types as $name => $payload) {
            AssetType::query()->firstOrCreate(['name' => $name], $payload);
        }

        $laptop = AssetType::query()->where('name', 'Laptop')->first();
        $phone = AssetType::query()->where('name', 'Handphone')->first();
        $monitor = AssetType::query()->where('name', 'Monitor')->first();
        $chair = AssetType::query()->where('name', 'Office Chair')->first();
        $printer = AssetType::query()->where('name', 'Printer')->first();

        $locations = [
            'HO-IT' => ['name' => 'Head Office - IT Area', 'floor' => '2'],
            'HO-OPS' => ['name' => 'Head Office - Operations Area', 'floor' => '1'],
            'HO-MEET' => ['name' => 'Head Office - Meeting Room', 'floor' => '1'],
        ];

        foreach ($locations as $code => $payload) {
            Location::query()->updateOrCreate(
                ['company_id' => $company->id, 'code' => $code],
                ['name' => $payload['name'], 'floor' => $payload['floor']]
            );
        }

        $assetRows = [
            ['AST-DEMO-IT-001', 'Laptop Admin Lenovo ThinkPad', $laptop?->id, 'Lenovo', 'ThinkPad E14', 'SN-IT-001', 'admin@assetflow.local'],
            ['AST-DEMO-IT-002', 'Handphone Admin Samsung', $phone?->id, 'Samsung', 'Galaxy A55', 'IMEI-IT-002', 'admin@assetflow.local'],
            ['AST-DEMO-IT-003', 'Laptop Manager Dell Latitude', $laptop?->id, 'Dell', 'Latitude 5440', 'SN-IT-003', 'manager@assetflow.local'],
            ['AST-DEMO-OPS-001', 'Laptop Operations HP ProBook', $laptop?->id, 'HP', 'ProBook 440', 'SN-OPS-001', 'employee@assetflow.local'],
            ['AST-DEMO-OPS-002', 'Handphone Operations iPhone', $phone?->id, 'Apple', 'iPhone 13', 'IMEI-OPS-002', 'employee@assetflow.local'],
            ['AST-DEMO-OPS-003', 'Laptop Operations Lead Acer', $laptop?->id, 'Acer', 'TravelMate', 'SN-OPS-003', 'ops.lead@assetflow.local'],
            ['AST-DEMO-FIN-001', 'Laptop Finance Asus', $laptop?->id, 'Asus', 'ExpertBook', 'SN-FIN-001', 'finance.staff@assetflow.local'],
        ];

        foreach ($assetRows as [$number, $name, $typeId, $brand, $model, $serial, $email]) {
            $asset = Asset::query()->updateOrCreate(
                ['asset_number' => $number],
                [
                    'company_id' => $company->id,
                    'asset_type_id' => $typeId,
                    'name' => $name,
                    'brand' => $brand,
                    'model' => $model,
                    'serial_number' => $serial,
                    'purchase_price' => 10000000,
                    'condition' => 'good',
                    'status' => 'used',
                    'notes' => 'Dummy aset untuk demo stock opname.',
                ]
            );

            $user = User::query()->where('email', $email)->first();
            if ($user) {
                EndUserAsset::query()->updateOrCreate(
                    ['asset_id' => $asset->id],
                    ['user_id' => $user->id, 'classification' => 'standard']
                );
            }
        }

        $officeRows = [
            ['AST-DEMO-OFF-001', 'Monitor Ruang IT', $monitor?->id, 'LG', '24MK600', 'SN-OFF-001', 'HO-IT'],
            ['AST-DEMO-OFF-002', 'Printer Operations', $printer?->id, 'Epson', 'L5290', 'SN-OFF-002', 'HO-OPS'],
            ['AST-DEMO-OFF-003', 'Kursi Meeting Room', $chair?->id, 'Generic', 'Ergo Chair', 'SN-OFF-003', 'HO-MEET'],
        ];

        foreach ($officeRows as [$number, $name, $typeId, $brand, $model, $serial, $locationCode]) {
            $asset = Asset::query()->updateOrCreate(
                ['asset_number' => $number],
                [
                    'company_id' => $company->id,
                    'asset_type_id' => $typeId,
                    'name' => $name,
                    'brand' => $brand,
                    'model' => $model,
                    'serial_number' => $serial,
                    'purchase_price' => 2500000,
                    'condition' => 'good',
                    'status' => 'used',
                    'notes' => 'Dummy aset kantor untuk demo stock opname.',
                ]
            );

            $location = Location::query()->where('company_id', $company->id)->where('code', $locationCode)->first();
            OfficeAsset::query()->updateOrCreate(
                ['asset_id' => $asset->id],
                ['location_id' => $location?->id]
            );
        }
    }
}
