<?php

namespace Database\Seeders;

use App\Models\Owner;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Owners dengan beberapa yang terverifikasi
        Owner::create([
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
            'phone_verified' => true, // Terverifikasi
            'email' => 'budi@example.com',
            'address' => 'Jl. Merdeka No. 123, Jakarta',
        ]);

        Owner::create([
            'name' => 'Siti Nurhaliza',
            'phone' => '081298765432',
            'phone_verified' => true, // Terverifikasi
            'email' => 'siti@example.com',
            'address' => 'Jl. Sudirman No. 45, Bandung',
        ]);

        Owner::create([
            'name' => 'Ahmad Dahlan',
            'phone' => '081345678901',
            'phone_verified' => true, // Terverifikasi
            'email' => 'ahmad@example.com',
            'address' => 'Jl. Gatot Subroto No. 78, Surabaya',
        ]);

        Owner::create([
            'name' => 'Rina Wijaya',
            'phone' => '081456789012',
            'phone_verified' => false, // Belum terverifikasi
            'email' => 'rina@example.com',
            'address' => 'Jl. Diponegoro No. 90, Yogyakarta',
        ]);

        Owner::create([
            'name' => 'Doni Prasetyo',
            'phone' => '081567890123',
            'phone_verified' => true, // Terverifikasi
            'email' => null,
            'address' => 'Jl. Ahmad Yani No. 56, Semarang',
        ]);

        // Seed Treatments
        $treatments = [
            [
                'name' => 'Vaksin Rabies',
                'type' => 'vaksin',
                'description' => 'Vaksinasi untuk pencegahan penyakit rabies',
                'price' => 150000,
            ],
            [
                'name' => 'Vaksin Distemper',
                'type' => 'vaksin',
                'description' => 'Vaksinasi untuk pencegahan penyakit distemper',
                'price' => 200000,
            ],
            [
                'name' => 'Grooming Basic',
                'type' => 'grooming',
                'description' => 'Perawatan dasar: mandi, potong kuku, bersihkan telinga',
                'price' => 100000,
            ],
            [
                'name' => 'Grooming Premium',
                'type' => 'grooming',
                'description' => 'Perawatan lengkap dengan styling dan aromaterapi',
                'price' => 250000,
            ],
            [
                'name' => 'Pemeriksaan Umum',
                'type' => 'pemeriksaan',
                'description' => 'Pemeriksaan kesehatan umum oleh dokter hewan',
                'price' => 75000,
            ],
            [
                'name' => 'Pemeriksaan Gigi',
                'type' => 'pemeriksaan',
                'description' => 'Pemeriksaan dan pembersihan gigi',
                'price' => 125000,
            ],
        ];

        foreach ($treatments as $treatment) {
            Treatment::create($treatment);
        }

        $this->command->info('✓ Seeder berhasil: ' . Owner::count() . ' owners & ' . Treatment::count() . ' treatments');
    }
}
