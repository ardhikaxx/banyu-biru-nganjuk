<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 8; $i++) {
            $user = User::updateOrCreate(
                ['email' => "pengguna{$i}@banyubiru.test"],
                [
                    'name' => "Pengguna Demo {$i}",
                    'phone' => '081230000'.str_pad((string) $i, 2, '0', STR_PAD_LEFT),
                    'address' => 'Nganjuk, Jawa Timur',
                    'password' => Hash::make('password'),
                ]
            );

            if (! $user->hasRole('user')) {
                $user->assignRole('user');
            }
        }
    }
}
