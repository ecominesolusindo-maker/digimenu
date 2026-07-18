<?php

namespace Database\Seeders;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\StaffProfile;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Roles
        $roles = ['Platform Admin', 'Owner', 'Cashier', 'Kitchen', 'Driver'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 2. Create Platform Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@restosaas.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]
        );
        $admin->assignRole('Platform Admin');

        // 3. Create 3 Restaurants
        for ($i = 1; $i <= 3; $i++) {
            $restaurant = Restaurant::firstOrCreate(
                ['slug' => 'resto-dummy-' . $i],
                [
                    'name' => 'Resto Dummy ' . $i,
                    'address' => 'Jl. Dummy No. ' . $i . ', Jakarta',
                    'phone' => '0812345678' . $i,
                    'subscription_status' => 'active',
                ]
            );

            // Owner
            $owner = User::firstOrCreate(
                ['email' => 'owner' . $i . '@restosaas.com'],
                [
                    'name' => 'Owner Resto ' . $i,
                    'password' => Hash::make('password'),
                    'restaurant_id' => $restaurant->id,
                    'role' => 'owner'
                ]
            );
            $owner->assignRole('Owner');

            // Tables
            for ($t = 1; $t <= 5; $t++) {
                Table::firstOrCreate(
                    ['restaurant_id' => $restaurant->id, 'table_number' => 'T' . $t],
                    [
                        'qr_code_token' => uniqid('qr_'),
                        'seating_capacity' => 4,
                    ]
                );
            }

            // Menu Categories & Items
            $cats = ['Makanan Utama', 'Minuman', 'Cemilan'];
            foreach ($cats as $catName) {
                $category = MenuCategory::firstOrCreate([
                    'restaurant_id' => $restaurant->id,
                    'name' => $catName,
                ]);

                for ($m = 1; $m <= 3; $m++) {
                    MenuItem::firstOrCreate([
                        'restaurant_id' => $restaurant->id,
                        'category_id' => $category->id,
                        'name' => $catName . ' ' . $m,
                        'price' => rand(15, 50) * 1000,
                        'description' => 'Deskripsi untuk ' . $catName . ' ' . $m,
                    ]);
                }
            }
        }
    }
}
