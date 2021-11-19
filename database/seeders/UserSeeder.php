<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('users')->get()->where('email', 'deljdl@gmail.com')->count() == 0){
            DB::table('users')->insert([
                'name' => 'Jardel',
                'email' => 'deljdl@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('r76247wd'),
                'remember_token' => \Illuminate\Support\Str::random(10)
            ]);
        }
        if(DB::table('users')->get()->where('email', 'hudysson@grupothx.com.br')->count() == 0){
            DB::table('users')->insert([
                'name' => 'Hudysson',
                'email' => 'hudysson@grupothx.com.br',
                'email_verified_at' => now(),
                'password' => bcrypt('r76247wd'),
                'remember_token' => \Illuminate\Support\Str::random(10)
            ]);
        }

        if(DB::table('users')->get()->where('email', 'junior@grupothx.com.br')->count() == 0){
            DB::table('users')->insert([
                'name' => 'Junior',
                'email' => 'junior@grupothx.com.br',
                'email_verified_at' => now(),
                'password' => bcrypt('r76247wd'),
                'remember_token' => \Illuminate\Support\Str::random(10)
            ]);
        }
    }
}
