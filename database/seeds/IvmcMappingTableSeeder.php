<?php

use Illuminate\Database\Seeder;
use App\IvmcMapping;

class IvmcMappingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IvmcMapping::table()->delete();

        IvmcMapping::create([
            'question_id' => 101,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Projekt_Nr'
        ]);

        /* 102: Project Title german / english */
        IvmcMapping::create([
            'question_id' => 102,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Langtitel_dt',
            'field_type' => 4,
            'display_order' => 3
        ]);

        IvmcMapping::create([
            'question_id' => 102,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Langtitel_en',
            'field_type' => 4,
            'display_order' => 4
        ]);

        /* 103: Abstract german */
        IvmcMapping::create([
            'question_id' => 103,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Abstract_dt',
            'field_type' => 1
        ]);

        /* 104: Abstract english */
        IvmcMapping::create([
            'question_id' => 104,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Abstract_en',
            'field_type' => 1
        ]);

        /* 105: Begin and End of Project */
        IvmcMapping::create([
            'question_id' => 105,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Laufzeit_von',
            'field_type' => 3,
            'display_order' => 1
        ]);

        IvmcMapping::create([
            'question_id' => 105,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Laufzeit_bis',
            'field_type' => 3,
            'display_order' => 2
        ]);

        /* 107: Principal Investigator (First Name, Last Name) */
        /*
        IvmcMapping::create([
            'question_id' => 107,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Projektleiter_Titel',
            'field_type' => 2,
            'display_order' => 1
        ]);
        */

        IvmcMapping::create([
            'question_id' => 107,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Projektleiter_Vorname',
            'field_type' => 2,
            'display_order' => 2
        ]);

        IvmcMapping::create([
            'question_id' => 107,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Projektleiter_Nachname',
            'field_type' => 2,
            'display_order' => 3
        ]);

        /* 109: Other Principal Investigators (First Name, Last Name) */
        IvmcMapping::create([
            'question_id' => 109,
            'source' => 't_821320_IVMC_DMP_Weitere_Projektleiter',
            'field' => 'Weitere_PL_Vorname',
            'field_type' => 6,
            'display_order' => 1
        ]);

        IvmcMapping::create([
            'question_id' => 109,
            'source' => 't_821320_IVMC_DMP_Weitere_Projektleiter',
            'field' => 'Weitere_PL_Nachname',
            'field_type' => 6,
            'display_order' => 2
        ]);

        /* 111: External Project Partner */
        IvmcMapping::create([
            'question_id' => 111,
            'source' => 't_821310_IVMC_DMP_Projektpartner_extern',
            'field' => 'Institution',
            'field_type' => 4,
            'display_order' => 1
        ]);

        /* 112: Funding Source */
        IvmcMapping::create([
            'question_id' => 112,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Mittelgeber',
            'field_type' => 4,
            'display_order' => 1
        ]);

        /* 113: Funding Program */
        IvmcMapping::create([
            'question_id' => 113,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Foerderprogramm',
            'field_type' => 4,
            'display_order' => 1
        ]);

        IvmcMapping::create([
            'question_id' => 113,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Hauptprogramm_1',
            'field_type' => 4,
            'display_order' => 2
        ]);

        IvmcMapping::create([
            'question_id' => 113,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Unterprogramm',
            'field_type' => 4,
            'display_order' => 3
        ]);

        /* 115: Funding Source */
        IvmcMapping::create([
            'question_id' => 115,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Projekttraeger',
            'field_type' => 4,
            'display_order' => 1
        ]);

        IvmcMapping::create([
            'question_id' => 115,
            'source' => 't_821300_IVMC_DMP_Projekt',
            'field' => 'Projekttraeger_KZ',
            'field_type' => 4,
            'display_order' => 2
        ]);
    }
}
