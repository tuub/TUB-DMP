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
        InputType::table()->delete();

        InputType::create([
            'id' => 1,
            'name' => 'Textfeld, einzeilig',
            'method' => 'text',
            'category' => 'text'
        ]);

        InputType::create([
            'id' => 2,
            'name' => 'Textfeld, mehrzeilig',
            'method' => 'textarea',
            'category' => 'text'
        ]);

        InputType::create([
            'id' => 3,
            'name' => 'Auswahlbox, einzeilig',
            'method' => 'select',
            'category' => 'option'
        ]);

        InputType::create([
            'id' => 4,
            'name' => 'Auswahlbox, mehrzeilig',
            'method' => 'multiselect',
            'category' => 'option'
        ]);

        InputType::create([
            'id' => 5,
            'name' => 'Liste',
            'method' => 'list',
            'category' => 'list',
        ]);

        InputType::create([
            'id' => 6,
            'name' => 'Checkboxen',
            'method' => 'checkboxes',
            'category' => 'option'
        ]);

        InputType::create([
            'id' => 7,
            'name' => 'Radiobuttons',
            'method' => 'radiobuttons',
            'category' => 'option'
        ]);

        InputType::create([
            'id' => 8,
            'name' => 'Datumsfeld',
            'method' => 'date',
            'category' => 'text'
        ]);

        InputType::create([
            'id' => 9,
            'name' => 'Datumsbereich',
            'method' => 'daterange',
            'category' => 'range'
        ]);

        InputType::create([
            'id' => 10,
            'name' => 'Wertefeld',
            'method' => 'value',
            'category' => 'text'
        ]);

        InputType::create([
            'id' => 11,
            'name' => 'Wertebereich',
            'method' => 'valuerange',
            'category' => 'range'
        ]);

        InputType::create([
            'id' => 12,
            'name' => 'Ja/Nein',
            'method' => 'boolean',
            'category' => 'option'
        ]);

        InputType::create([
            'id' => 13,
            'name' => 'Plain (not editable)',
            'method' => 'plain',
            'category' => 'text'
        ]);

        InputType::create([
            'id' => 99,
            'name' => 'Frage als Überschrift',
            'method' => 'headline',
            'category' => 'headline'
        ]);

    }
}
