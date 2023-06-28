<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "admin",
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'email_verified_at' => Carbon::now(),
            'role' => 0
        ]);
    }
}