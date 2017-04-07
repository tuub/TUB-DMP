<?php

use Illuminate\Database\Seeder;
use App\InputType;

class InputTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InputType::create([
            'id' => 1,
            'title' => 'Textfeld, einzeilig',
            'identifier' => 'text',
            'category' => 'text'
        ]);

        InputType::create([
            'id' => 2,
            'title' => 'Textfeld, mehrzeilig',
            'identifier' => 'textarea',
            'category' => 'text'
        ]);

        InputType::create([
            'id' => 3,
            'title' => 'Auswahlbox, einzeilig',
            'identifier' => 'select',
            'category' => 'option'
        ]);

        InputType::create([
            'id' => 4,
            'title' => 'Auswahlbox, mehrzeilig',
            'identifier' => 'multiselect',
            'category' => 'option'
        ]);

        InputType::create([
            'id' => 5,
            'title' => 'Liste',
            'identifier' => 'list',
            'category' => 'list',
        ]);

        InputType::create([
            'id' => 6,
            'title' => 'Checkboxen',
            'identifier' => 'checkboxes',
            'category' => 'option'
        ]);

        InputType::create([
            'id' => 7,
            'title' => 'Radiobuttons',
            'identifier' => 'radiobuttons',
            'category' => 'option'
        ]);

        InputType::create([
            'id' => 8,
            'title' => 'Datumsfeld',
            'identifier' => 'date',
            'category' => 'text'
        ]);

        InputType::create([
            'id' => 9,
            'title' => 'Datumsbereich',
            'identifier' => 'daterange',
            'category' => 'range'
        ]);

        InputType::create([
            'id' => 10,
            'title' => 'Wertefeld',
            'identifier' => 'value',
            'category' => 'text'
        ]);

        InputType::create([
            'id' => 11,
            'title' => 'Wertebereich',
            'identifier' => 'valuerange',
            'category' => 'range'
        ]);

        InputType::create([
            'id' => 12,
            'title' => 'Ja/Nein',
            'identifier' => 'boolean',
            'category' => 'option'
        ]);

        InputType::create([
            'id' => 13,
            'title' => 'Plain (not editable)',
            'identifier' => 'plain',
            'category' => 'text'
        ]);

        InputType::create([
            'id' => 14,
            'title' => 'Person',
            'identifier' => 'person',
            'category' => 'inputgroup'
        ]);

        InputType::create([
            'id' => 15,
            'title' => 'Organization',
            'identifier' => 'organization',
            'category' => 'inputgroup'
        ]);

        InputType::create([
            'id' => 16,
            'title' => 'Text with Language Selection',
            'identifier' => 'text_with_language',
            'category' => 'inputgroup'
        ]);

        InputType::create([
            'id' => 17,
            'title' => 'Textarea with Language Selection',
            'identifier' => 'textarea_with_language',
            'category' => 'inputgroup'
        ]);

        InputType::create([
            'id' => 99,
            'title' => 'Frage als Überschrift',
            'identifier' => 'headline',
            'category' => 'headline'
        ]);

    }
}
