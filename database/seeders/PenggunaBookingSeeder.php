<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Place;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PenggunaBookingSeeder extends Seeder
{
    public function run(): void
    {
        $place = Place::where('name', 'Pendopo')->first();
        $admin = User::where('email', 'admin@banyubiru.com')->first();
        $users = User::role('user')->orderBy('id')->get();

        if (! $place || $users->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'confirmed', 'rejected'];

        for ($i = 1; $i <= 14; $i++) {
            $bookingDate = Carbon::now()->subMonths($i % 10)->addDays(($i * 3) % 22 + 1)->toDateString();
            $status = $statuses[$i % 3];
            $bookingCode = 'AB-DEMO-'.str_pad((string) $i, 3, '0', STR_PAD_LEFT);

            Booking::updateOrCreate(
                ['booking_code' => $bookingCode],
                [
                    'user_id' => $users[$i % $users->count()]->id,
                    'place_id' => $place->id,
                    'booking_date' => $bookingDate,
                    'visitor_name' => 'Pengunjung Demo '.$i,
                    'visitor_phone' => '081245000'.str_pad((string) $i, 2, '0', STR_PAD_LEFT),
                    'visitor_address' => 'Nganjuk, Jawa Timur',
                    'num_persons' => 10 + ($i % 20),
                    'total_price' => $place->price_per_day,
                    'status' => $status,
                    'confirmed_at' => $status === 'confirmed' ? now()->subDays($i) : null,
                    'confirmed_by' => $status === 'confirmed' && $admin ? $admin->id : null,
                    'rejection_note' => $status === 'rejected' ? 'Jadwal bentrok dengan reservasi lain.' : null,
                    'notes' => 'Booking seeded untuk dashboard demo.',
                ]
            );
        }
    }
}
