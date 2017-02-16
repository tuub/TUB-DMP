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
        Plan::create([
            'id' => 1,
            'title' => 'Data Management Plan',
            'project_id' => 1,
            'version' => 1,
            'template_id' => 1,
            'is_active' => 1,
            'is_final' => 0
        ]);
    }
}
