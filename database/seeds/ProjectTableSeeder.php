<?php

use Illuminate\Database\Seeder;
use App\Project;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ProjectTableSeeder extends Seeder
{
    public function run()
    {
        //TestDummy::times(1)->create('App\Project');
        Project::create([
            'id' => 1,
            'identifier' => 'DMP-5917548237',
            'user_id' => 4,
            'imported' => 1,
            'imported_at' => '2016-05-27 14:45:01',
            'created_at' => '2016-05-27 14:44:45',
            'updated_at' => '2016-05-27 14:45:01',
        ]);

        Project::create([
            'id' => 2,
            'identifier' => 'DMP-8945900116',
            'user_id' => 6,
            'imported' => 1,
            'imported_at' => '2016-06-01 12:58:01',
            'created_at' => '2016-06-01 12:57:31',
            'updated_at' => '2016-06-01 12:58:01',
        ]);

        Project::create([
            'id' => 3,
            'identifier' => 'DMP-9372909072',
            'user_id' => 7,
            'imported' => 1,
            'imported_at' => '2016-07-25 10:21:02',
            'created_at' => '2016-07-25 10:20:08',
            'updated_at' => '2016-07-26 10:00:25',
        ]);

        Project::create([
            'id' => 4,
            'identifier' => '10043166',
            'user_id' => 8,
            'imported' => 1,
            'data_source_id' => 1,
            'imported_at' => '2016-07-25 10:28:04',
            'created_at' => '2016-07-25 10:28:00',
            'updated_at' => '2016-08-23 15:55:29',
        ]);

        Project::create([
            'id' => 5,
            'identifier' => 'DMP-1960869669',
            'user_id' => 9,
            'imported' => 1,
            'imported_at' => '2016-07-25 10:36:01',
            'created_at' => '2016-07-25 10:35:25',
            'updated_at' => '2016-08-04 15:40:31',
        ]);

        Project::create([
            'id' => 6,
            'identifier' => '10041834',
            'user_id' => 10,
            'data_source_id' => 1,
            'imported' => 1,
            'imported_at' => '2016-07-25 10:39:02',
            'created_at' => '2016-07-25 10:38:51',
            'updated_at' => '2016-07-29 00:06:18',
        ]);

        Project::create([
            'id' => 7,
            'identifier' => 'DMP-2650722097',
            'user_id' => 11,
            'imported' => 1,
            'imported_at' => '2016-10-21 13:13:02',
            'created_at' => '2016-10-21 13:12:19',
            'updated_at' => '2016-10-21 14:10:02',
        ]);

        Project::create([
            'id' => 8,
            'identifier' => 'DMP-1447596657',
            'user_id' => 12,
            'imported' => 1,
            'imported_at' => '2016-11-29 11:44:02',
            'created_at' => '2016-11-29 11:43:55',
            'updated_at' => '2016-11-29 11:44:02',
        ]);

        Project::create([
            'id' => 9,
            'identifier' => 'pbr1',
            'user_id' => 13,
            'imported' => 1,
            'imported_at' => '2017-01-27 12:10:02',
            'created_at' => '2017-01-27 12:09:58',
            'updated_at' => '2017-01-27 12:10:02',
        ]);

        Project::create([
            'id' => 10,
            'identifier' => '10043293',
            'user_id' => 14,
            'data_source_id' => 1,
            'imported' => 1,
            'imported_at' => '2017-02-07 11:37:04',
            'created_at' => '2017-02-07 11:36:31',
            'updated_at' => '2017-02-22 17:25:26',
        ]);

        Project::create([
            'id' => 11,
            'identifier' => 'DMP-3771538582',
            'user_id' => 16,
            'imported' => 1,
            'imported_at' => '2017-03-07 09:15:02',
            'created_at' => '2017-03-07 09:14:34',
            'updated_at' => '2017-03-07 09:15:02',
        ]);

        Project::create([
            'id' => 12,
            'identifier' => 'DMP-7684222088',
            'user_id' => 17,
            'imported' => 1,
            'imported_at' => '2017-03-13 12:50:02',
            'created_at' => '2017-03-13 12:49:15',
            'updated_at' => '2017-03-13 12:50:03',
        ]);

        Project::create([
            'id' => 13,
            'identifier' => '123-456',
            'user_id' => 1,
            'data_source_id' => 1,
            'imported' => 0,
            'created_at' => '2016-05-27 14:44:45',
            'updated_at' => '2016-05-27 14:45:01',
        ]);
    }
}