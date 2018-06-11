<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IVMCDMPProjektTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('t_821300_IVMC_DMP_Projekt')->insert([
            [
                'ID_KTR' => 1,
                'ID_MA' => 2,
                'ID_MG' => 3,
                'ID_PT' => 4,
                'ID_MG_Pr' => 5,
                'ID_HP_1' => 6,
                'ID_HP_2' => 7,
                'Projekt_Nr' => '12345678',
                'Proj_Kurzbezeichnung' => 'Das geheime Leben der Daten-BibliothekarInnen',
                'Laufzeit_von' => '2012-08-21',
                'Laufzeit_bis' => '2020-12-31',
                'OM' => '123456',
                'Kostenstelle' => '4600112233',
                'Rang' => null,
                'Projektleiter_Nachname' => 'Mustermann',
                'Projektleiter_Vorname' => 'Max',
                'Projektleiter_Titel' => 'Professor',
                'Projektleiter_email' => 'mustermann@example.org',
                'Mittelgeber' => 'ACME Universität',
                'Projekttraeger' => 'DFV',
                'Projekttraeger_KZ' => '123',
                'Foerderprogramm' => 'ACME Funding Programme #3',
                'Hauptprogramm_1' => 'Main Programme #1',
                'Unterprogramm' => 'Sub Programme #43',
                'Langtitel_dt' => 'Das geheime Leben der Daten-BibliothekarInnen',
                'Langtitel_en' => 'The secret life of data librarians',
                'Acronym' => 'SECRET-DATA',
                'Abstract_dt' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, ...',
                'Abstract_en' => 'The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words. If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages. It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is.The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. '
            ],
        ]);
    }
}