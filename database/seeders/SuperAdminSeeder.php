<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $email = env('SUPERADMIN_EMAIL');
        
        if (!$email) {
            $this->command->error('SUPERADMIN_EMAIL non défini.');
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => env('SUPERADMIN_NAME', 'Super Admin'),
                'password' => Hash::make(env('SUPERADMIN_PASSWORD', 'password')),
                'role' => Role::SUPERADMIN,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('SuperAdmin synchronisé avec succès.');
    }
}
