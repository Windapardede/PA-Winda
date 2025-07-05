<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;       // <-- Import DB Facade
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema; // <-- Import Schema Facade

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // 1. Nonaktifkan pengecekan foreign key
        // Schema::disableForeignKeyConstraints();

        // // 2. Kosongkan tabel yang berelasi
        // // (Kosongkan tabel 'anak' dulu, baru tabel 'induk')
        // DB::table('attendances')->truncate();
        // User::truncate();

        // // 3. Aktifkan kembali pengecekan foreign key
        // Schema::enableForeignKeyConstraints();

        // 4. Buat data baru
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('admin123'),
        //     'role' => 'admin',
        // ]);

        // User::create([
        //     'name' => 'HRD',
        //     'email' => 'hrd@example.com',
        //     'password' => Hash::make('hrd123'),
        //     'role' => 'hrd',
        // ]);


        User::create([
            'name' => 'Admin',
            'email' => 'winda.idch.intern@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'HRD',
            'email' => 'raniasiregar50@gmail.com',
            'password' => Hash::make('hrd123'),
            'role' => 'hrd',
        ]);
    }
}
