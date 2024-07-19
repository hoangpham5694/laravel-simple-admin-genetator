<?php

namespace HoangPham\SimpleAdminGeneration\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (empty(DB::table('admins')->find(1))) {
            DB::table('admins')->insert([
                'first_name' => 'Admin',
                'last_name' => 'SAG',
                'email' => 'admin@sag.com',
                'password' => bcrypt('secret'),
                'is_super_user' => 1
            ]);
        }
    }
}
