<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(InputTypesTableSeeder::class);
        $this->call(ContentTypesTableSeeder::class);
        $this->call(MetadataRegistryTableSeeder::class);
    }
}
