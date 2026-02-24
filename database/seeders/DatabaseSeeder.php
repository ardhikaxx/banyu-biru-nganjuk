<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\Place;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@banyubiru.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        $mainTicket = Ticket::updateOrCreate(
            ['name' => 'Tiket Masuk'],
            [
                'price' => 5000,
                'quota_per_day' => 500,
                'description' => 'Tiket masuk umum Banyu Biru (Rp 5.000 per orang)',
                'is_active' => 1,
            ]
        );
        Ticket::where('id', '!=', $mainTicket->id)->update(['is_active' => 0]);

        $pendopo = Place::updateOrCreate(
            ['name' => 'Pendopo'],
            [
                'price_per_day' => 500000,
                'capacity' => 50,
                'description' => 'Tempat acara keluarga',
                'is_active' => 1,
            ]
        );
        Place::where('id', '!=', $pendopo->id)->update(['is_active' => 0]);

        BankAccount::firstOrCreate(
            ['account_number' => '1234567890'],
            [
                'bank_name' => 'BRI',
                'account_name' => 'Banyu Biru Nganjuk',
                'is_active' => 1,
            ]
        );

        $this->call([
            PenggunaSeeder::class,
            PenggunaTiketSeeder::class,
            PenggunaBookingSeeder::class,
        ]);
    }
}
