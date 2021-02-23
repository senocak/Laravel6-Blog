<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    public function run(){
        $this->call(KategoriSeeder::class);
        $this->call(YazıSeeder::class);
        $this->call(YorumSeeder::class);
        $this->call(UserSeeder::class);
    }
}
