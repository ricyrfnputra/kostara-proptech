<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\MaintenanceRecord;
use App\Models\Report;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Password dummy hanya untuk development lokal
        $password = Hash::make('password');

        // 1 owner
        User::create([
            'name' => 'Pemilik Kost',
            'email' => 'owner@kostara.test',
            'password' => $password,
            'role' => 'owner',
            'phone' => '081200000000',
        ]);

        // 5 kamar (kamar 105 sengaja dikosongkan)
        $rooms = [];
        foreach (['101', '102', '103', '104', '105'] as $number) {
            $rooms[$number] = Room::create([
                'room_number' => $number,
                'price' => 800000,
            ]);
        }

        // 4 tenant, masing-masing di 1 kamar
        $tenants = [];
        $names = ['Budi Santoso', 'Siti Aminah', 'Rina Wijaya', 'Andi Pratama'];
        foreach (['101', '102', '103', '104'] as $i => $number) {
            $tenants[$number] = User::create([
                'name' => $names[$i],
                'email' => 'tenant' . ($i + 1) . '@kostara.test',
                'password' => $password,
                'role' => 'tenant',
                'phone' => '08120000000' . ($i + 1),
                'room_id' => $rooms[$number]->id,
            ]);
        }

        // Laporan kerusakan dengan status dan prioritas bervariasi
        $r1 = Report::create([
            'user_id' => $tenants['101']->id,
            'room_id' => $rooms['101']->id,
            'title' => 'Stopkontak percikan api',
            'description' => 'Stopkontak dekat kasur mengeluarkan percikan saat colokan dipasang.',
            'category' => 'listrik',
            'priority' => 'high',
            'status' => 'diajukan',
        ]);

        $r2 = Report::create([
            'user_id' => $tenants['102']->id,
            'room_id' => $rooms['102']->id,
            'title' => 'AC tidak dingin',
            'description' => 'AC menyala tetapi udara yang keluar tidak dingin.',
            'category' => 'ac',
            'priority' => 'medium',
            'status' => 'diproses',
        ]);

        $r3 = Report::create([
            'user_id' => $tenants['103']->id,
            'room_id' => $rooms['103']->id,
            'title' => 'Cat dinding mengelupas',
            'description' => 'Cat dinding di sudut kamar mengelupas.',
            'category' => 'bangunan',
            'priority' => 'low',
            'status' => 'selesai',
        ]);

        // Riwayat maintenance untuk laporan yang sudah diproses/selesai
        MaintenanceRecord::create([
            'report_id' => $r2->id,
            'technician' => 'Pak Joko',
            'cost' => 150000,
            'maintenance_date' => now()->subDays(1),
            'notes' => 'Pengecekan freon dan pembersihan filter.',
        ]);

        MaintenanceRecord::create([
            'report_id' => $r3->id,
            'technician' => 'Pak Dedi',
            'cost' => 75000,
            'maintenance_date' => now()->subDays(5),
            'notes' => 'Pengecatan ulang dinding.',
        ]);

        // Tagihan dengan berbagai kondisi tanggal untuk menguji 4 status
        Bill::create([ // BELUM JATUH TEMPO
            'user_id' => $tenants['101']->id,
            'room_id' => $rooms['101']->id,
            'amount' => 800000,
            'due_date' => now()->addDays(20),
        ]);

        Bill::create([ // MENDEKATI JATUH TEMPO
            'user_id' => $tenants['102']->id,
            'room_id' => $rooms['102']->id,
            'amount' => 800000,
            'due_date' => now()->addDays(2),
        ]);

        Bill::create([ // TUNGGAKAN
            'user_id' => $tenants['103']->id,
            'room_id' => $rooms['103']->id,
            'amount' => 800000,
            'due_date' => now()->subDays(4),
        ]);

        Bill::create([ // LUNAS
            'user_id' => $tenants['104']->id,
            'room_id' => $rooms['104']->id,
            'amount' => 800000,
            'due_date' => now()->addDays(10),
            'status' => 'paid',
            'paid_at' => now()->subDays(1),
        ]);
    }
}