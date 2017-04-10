<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(InputTypeTableSeeder::class);
        $this->call(ContentTypeTableSeeder::class);
        $this->call(DataSourceTableSeeder::class);
        $this->call(InstitutionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ProjectTableSeeder::class);
        $this->call(TemplateTableSeeder::class);
        $this->call(SectionTableSeeder::class);
        //$this->call(PlanTableSeeder::class);
        $this->call(QuestionTableSeeder::class);
        $this->call(QuestionOptionTableSeeder::class);
        //$this->call(IvmcFieldTypeTableSeeder::class);
        //$this->call(IvmcMappingTableSeeder::class);
        $this->call(MetadataRegistryTableSeeder::class);
        //$this->call(ProjectMetadataTableSeeder::class);
        $this->call(DataSourceNamespaceTableSeeder::class);
        $this->call(DataSourceMappingTableSeeder::class);

        //$this->call(SurveyTableSeeder::class);
        //$this->call(AnswerTableSeeder::class);
    }
}
