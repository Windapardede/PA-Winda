<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key checks (kalau tabel ini punya foreign key)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus semua data dari tabel testimoni
        DB::table('testimoni')->truncate();

        // Aktifkan lagi foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
