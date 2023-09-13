<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role =  Role::create([
            'name' => 'UGCS-ADMIN',
            'guard_name' => 'admin',
        ]);
        $main = Admin::create([
            'name' => 'Super Admin',
            'username' => 'nimda',
            'staffid' => '27672',
            'password' => Hash::make('P@ssw0rd.135')
        ]);

        $main->assignRole($role);
    }
}
