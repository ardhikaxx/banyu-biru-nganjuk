<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Ahmad Fauzi',
            'Siti Rahayu',
            'Budi Santoso',
            'Dewi Lestari',
            'Rudi Hermawan',
            'Fitri Amalia',
            'Joko Pramono',
            'Nur Hidayah'
        ];

        $emails = [
            'ahmad.fauzi@gmail.com',
            'siti.rahayu@gmail.com',
            'budi.santoso@gmail.com',
            'dewi.lestari@gmail.com',
            'rudi.hermawan@gmail.com',
            'fitri.amalia@gmail.com',
            'joko.pramono@gmail.com',
            'nur.hidayah@gmail.com'
        ];

        for ($i = 0; $i < 8; $i++) {
            $user = User::updateOrCreate(
                ['email' => $emails[$i]],
                [
                    'name' => $names[$i],
                    'phone' => '081230000'.str_pad((string) ($i+1), 2, '0', STR_PAD_LEFT),
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
