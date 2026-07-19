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
        // Pastikan role Spatie ada sebelum di-assign
        $roleCashier = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Cashier', 'guard_name' => 'web']);
        $roleKitchen = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Kitchen', 'guard_name' => 'web']);

        $c = \App\Models\User::firstOrCreate(
            ['email' => 'cashier@restosaas.com'], 
            ['name' => 'Cashier', 'password' => \Illuminate\Support\Facades\Hash::make('password'), 'role' => 'cashier', 'restaurant_id' => 1]
        );
        $c->assignRole($roleCashier);

        $k = \App\Models\User::firstOrCreate(
            ['email' => 'kitchen@restosaas.com'], 
            ['name' => 'Kitchen Staff', 'password' => \Illuminate\Support\Facades\Hash::make('password'), 'role' => 'kitchen', 'restaurant_id' => 1]
        );
        $k->assignRole($roleKitchen);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \App\Models\User::whereIn('email', ['cashier@restosaas.com', 'kitchen@restosaas.com'])->delete();
    }
};
