<?php

use Illuminate\Database\Seeder;
use App\Plan;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::table()->delete();

        Plan::create([
            'id' => 1,
            'project_number' => 'DMP-123',
            'version' => 1,
            'template_id' => 1,
            'user_id' => 1,
            'datasource' => null,
            'is_active' => 1,
            'is_final' => 0
        ]);
    }
}
