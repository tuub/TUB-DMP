<?php

use Illuminate\Database\Seeder;
use App\Section;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::create([
            'id' => 1,
            'template_id' => 1,
            'keynumber' => '1',
            'order' => 1,
            'name' => 'General Project Information',
            'is_active' => 0,
        ]);

        Section::create([
            'id' => 2,
            'template_id' => 1,
            'keynumber' => '1',
            'order' => 1,
            'name' => 'Related Policies',
            'guidance' => 'List any other relevant funder, institutional, departmental or group policies on data management, data sharing and data security. Some of the information you give in the remainder of the DMP will be determined by the content of other policies. If so, point/link to them there.',
        ]);

        Section::create([
            'id' => 3,
            'template_id' => 1,
            'keynumber' => '2',
            'order' => 2,
            'name' => 'Data Collection'
        ]);

        Section::create([
            'id' => 4,
            'template_id' => 1,
            'keynumber' => '3',
            'order' => 3,
            'name' => 'Documentation and Metadata'
        ]);

        Section::create([
            'id' => 5,
            'template_id' => 1,
            'keynumber' => '4',
            'order' => 4,
            'name' => 'Ethics and Legal Compliance'
        ]);

        Section::create([
            'id' => 6,
            'template_id' => 1,
            'keynumber' => '5',
            'order' => 5,
            'name' => 'Storage and Backup'
        ]);

        Section::create([
            'id' => 7,
            'template_id' => 1,
            'keynumber' => '6',
            'order' => 6,
            'name' => 'Selection and Preservation'
        ]);

        Section::create([
            'id' => 8,
            'template_id' => 1,
            'keynumber' => '7',
            'order' => 7,
            'name' => 'Data Sharing'
        ]);

        Section::create([
            'id' => 9,
            'template_id' => 1,
            'keynumber' => '8',
            'order' => 8,
            'name' => 'Responsibilities and Resources'
        ]);
    }
}
