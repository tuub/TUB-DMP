<?php

use Illuminate\Database\Seeder;
use App\ProjectMetadata;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ProjectMetadataTableSeeder extends Seeder
{
    public function run()
    {
        //TestDummy::times(1)->create('App\Project');

        ProjectMetadata::create([
            'project_id' => 3,
            'metadata_registry_id' => 1,
            'content' => [['content' => 'ASPIRE', 'language' => 'de']],
        ]);

        ProjectMetadata::create([
            'project_id' => 3,
            'metadata_registry_id' => 5,
            'content' => [
                ['content' => 'proposal', 'language' => 'en']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 3,
            'metadata_registry_id' => 6,
            'content' => [
                ['firstname' => 'Leon', 'lastname' => 'Hempel', 'email' => '', 'uri' => '']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 4,
            'metadata_registry_id' => 1,
            'content' => [
                ['content' => 'Artist-to-Business-to-Business-to-Consumer Audio Branding System', 'language' => 'en']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 4,
            'metadata_registry_id' => 2,
            'content' => [
                ['content' => 'The current European market for audio branding services is lopsided, both in economic terms as well as in aspects of cultural identity. In the slipstream of big U.S. companies like McDonald\'s, North American providers have captured the European (and worldwide) market for instore music and have held a strong position ever since. Today the worldwide market is effectively monopolised by two \'big players\' from the USA. At the same time European creative industries active in this area are pushed into a corner of the European as well as the worldwide market and for the most part serve only niche businesses.
The ABC DJ project seeks to provide European creative agencies in the field of audio branding with sophisticated ICT supporting tools. As a result they will be able to offer branding services and products of such high quality that they can successfully compete with the current big players, independently of their respective size – be it a big agency, an SME or a one-man business. Secondly, European creators of music, (independent) labels as well as respective multipliers will be actively included into the audio branding value chains and enjoy support and novel schemes from the monetisation of their works as instore music. The pool of music effectively exploitable for branding agencies and brand clients will thus grow significantly. The high number of creative micro-businesses and SMEs is tailor-made for an approach where many audio branding agencies serve the (diverse) needs of many brands, as opposed to the current \'one-sound-fits-all\' situation.', 'language' => 'de'],
                ['content' => 'The current European market for audio branding services is lopsided, both in economic terms as well as in aspects of cultural identity. In the slipstream of big U.S. companies like McDonald\'s, North American providers have captured the European (and worldwide) market for instore music and have held a strong position ever since. Today the worldwide market is effectively monopolised by two \'big players\' from the USA. At the same time European creative industries active in this area are pushed into a corner of the European as well as the worldwide market and for the most part serve only niche businesses.
The ABC DJ project seeks to provide European creative agencies in the field of audio branding with sophisticated ICT supporting tools. As a result they will be able to offer branding services and products of such high quality that they can successfully compete with the current big players, independently of their respective size – be it a big agency, an SME or a one-man business. Secondly, European creators of music, (independent) labels as well as respective multipliers will be actively included into the audio branding value chains and enjoy support and novel schemes from the monetisation of their works as instore music. The pool of music effectively exploitable for branding agencies and brand clients will thus grow significantly. The high number of creative micro-businesses and SMEs is tailor-made for an approach where many audio branding agencies serve the (diverse) needs of many brands, as opposed to the current \'one-sound-fits-all\' situation.', 'language' => 'en']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 4,
            'metadata_registry_id' => 3,
            'content' => ['2016-01-01'],
        ]);

        ProjectMetadata::create([
            'project_id' => 4,
            'metadata_registry_id' => 4,
            'content' => ['2018-12-31'],
        ]);

        ProjectMetadata::create([
            'project_id' => 4,
            'metadata_registry_id' => 6,
            'content' => [['firstname' => 'Stefan', 'lastname' => 'Weinzierl', 'email' => '', 'uri' => '']],
        ]);

        ProjectMetadata::create([
            'project_id' => 4,
            'metadata_registry_id' => 8,
            'content' => [
                'HearDis! Corporate Sound GmbH',
                'Institut de Recherche et Coordination Acoustique/Musique',
                'Fincons S.p.A',
                'Lovemonk S.L.',
                'INTEGRAL Markt- und Meinungsforschungsges.m.b.H',
                'Fratelli Piacenza S.p.A.'
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 4,
            'metadata_registry_id' => 9,
            'content' => ['EU - Kommission der Europäischen Gemeinschaften'],
        ]);

        ProjectMetadata::create([
            'project_id' => 4,
            'metadata_registry_id' => 10,
            'content' => ['HORIZON 2020'],
        ]);

        ProjectMetadata::create([
            'project_id' => 4,
            'metadata_registry_id' => 12,
            'content' => ['EU - Kommission der Europäischen Gemeinschaften'],
        ]);

        ProjectMetadata::create([
            'project_id' => 5,
            'metadata_registry_id' => 1,
            'content' => [['content' => 'Technik für alle', 'language' => 'de']],
        ]);

        ProjectMetadata::create([
            'project_id' => 5,
            'metadata_registry_id' => 2,
            'content' => [
                ['content' => 'Bla Bla', 'language' => 'de'],
                ['content' => 'Bla Bla', 'language' => 'en'],
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 5,
            'metadata_registry_id' => 3,
            'content' => ['2016-08-17'],
        ]);

        ProjectMetadata::create([
            'project_id' => 5,
            'metadata_registry_id' => 4,
            'content' => ['2020-08-04'],
        ]);

        ProjectMetadata::create([
            'project_id' => 5,
            'metadata_registry_id' => 5,
            'content' => [['content' => 'Bla Bla', 'language' => 'de']],
        ]);


        ProjectMetadata::create([
            'project_id' => 6,
            'metadata_registry_id' => 1,
            'content' => [
                ['content' => 'Verbundprojekt: Industrielle CloudbASierte SteuerungsplattfOrm für eine Produktion mit cyber-physischen Systemen (pICASSO); Teilprojekt: Benutzer- und Steuerungsschnittstellen für cloudbasierte Mehrwertdienste', 'language' => 'de']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 6,
            'metadata_registry_id' => 2,
            'content' => [
                ['content' => 'Das Ziel des Forschungsvorhabens pICASSO ist daher die flexible Bereitstellung von Steuerungstechnik für Cyber-Physische Systeme in der industriellen Produktion. Die vorhandene, monolithische Steuerungstechnik soll aufgebrochen, modularisiert und mit Mechanismen des Cloud-Computing, wie zentraler Datenverarbeitung und Service-Orientierten Softwarearchitekturen, erweitert werden.', 'language' => 'de']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 6,
            'metadata_registry_id' => 3,
            'content' => ['2013-10-01'],
        ]);

        ProjectMetadata::create([
            'project_id' => 6,
            'metadata_registry_id' => 4,
            'content' => ['2016-09-30'],
        ]);

        ProjectMetadata::create([
            'project_id' => 6,
            'metadata_registry_id' => 6,
            'content' => [
                ['firstname' => 'Jörg', 'lastname' => 'Krüger', 'email' => '', 'uri' => '']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 6,
            'metadata_registry_id' => 8,
            'content' => [
                'Sotec Software- Entwicklungs- GmbH & Co',
                'Robert Bosch GmbH',
                'Automata GmbH & Co. KG',
                'Universität Stuttgart',
                'Reis GmbH & Co. KG Maschinenfabrik',
                'Homag Holzbearbeitungssysteme GmbH'
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 6,
            'metadata_registry_id' => 9,
            'content' => ['Bundesministerium für Bildung und Forschung (BMBF)'],
        ]);

        ProjectMetadata::create([
            'project_id' => 6,
            'metadata_registry_id' => 12,
            'content' => ['Karlsruher Institut für Technologie (KIT)'],
        ]);

        ProjectMetadata::create([
            'project_id' => 7,
            'metadata_registry_id' => 1,
            'content' => [
                ['content' => 'OPen-Access Lab for Beyond-5G technologies', 'language' => 'en']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 7,
            'metadata_registry_id' => 3,
            'content' => ['2017-06-01'],
        ]);

        ProjectMetadata::create([
            'project_id' => 7,
            'metadata_registry_id' => 4,
            'content' => ['2019-12-31'],
        ]);

        ProjectMetadata::create([
            'project_id' => 7,
            'metadata_registry_id' => 5,
            'content' => [
                ['content' => 'Antrag', 'language' => 'de'],
                ['content' => 'proposal', 'language' => 'en']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 7,
            'metadata_registry_id' => 6,
            'content' => [
                ['firstname' => 'Giuseppe', 'lastname' => 'Caire', 'email' => '', 'uri' => '']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 7,
            'metadata_registry_id' => 7,
            'content' => [
                ['firstname' => 'Thomas', 'lastname' => 'Kühne', 'email' => '', 'uri' => ''],
                ['firstname' => 'Andreas', 'lastname' => 'Benzin', 'email' => '', 'uri' => '']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 7,
            'metadata_registry_id' => 8,
            'content' => [
                'Consorzio Nazionale Interuniversitario per le Telecomunicazioni (CNIT)',
                'Centre Tecnològic Telecomunicacions de Catalunya (CTTC)',
                'Centre National de la Recherche Scientifique (CNRS)',
                'EURECOM',
                'Martel Innovate'
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 7,
            'metadata_registry_id' => 9,
            'content' => ['European Commision'],
        ]);

        ProjectMetadata::create([
            'project_id' => 7,
            'metadata_registry_id' => 10,
            'content' => ['FP7 H2020'],
        ]);

        ProjectMetadata::create([
            'project_id' => 7,
            'metadata_registry_id' => 12,
            'content' => [
                'Consorzio Nazionale Interuniversitario per le Telecomunicazioni (CNIT), Centre Tecnològic Telecomunicacions de Catalunya (CTTC)'
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 10,
            'metadata_registry_id' => 1,
            'content' => [
                ['content' => 'Low-Power Parallel Computing on GPUs 2', 'language' => 'en']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 10,
            'metadata_registry_id' => 2,
            'content' => [
                ['content' => 'Low-power GPUs have become ubiquitous. They can be found in domains ranging from wearable and mobile computing, to automotive systems. With this ubiquity has come a wider range of opportunities of applications exploiting low-power GPUs, placing ever increasing demands on the expected performance and power eciency of the devices.
    Future low-power system-on-chips will have to provide higher performance and be able to support more complex applications, without using any additional power.
    The strict power limitations means, however, that these demands cannot be met through hardware improvements alone, but the software must fully exploit the available resources. Unfortunately, application developers are seriously hindered when creating low-power GPU software by the limited quality of current performance analysis tools. In low-power GPU contexts there is only a minimal amount of performance information, and essentially no power information, available to the programmer. As software becomes more complex it becomes increasingly unmanageable for programmers to optimise the software for low-power devices.
    This project proposes to aid the application developer in creating software for low-power GPUs by building on the results of the first LPGPU project by providing a complete performance and power analysis process for the programmer. This project will address all aspects of performance analysis, from hardware power and performance counters, to a framework that processes and visualises information from these counters, to applications that will be used as use-cases to drive the entire design. To access the new hardware performance counters a standardisable API will be produced to interface to a prototype hardware implementation. This will let the analysis and visualisation framework connect to any GPU driver that implements the API. The consortium’s expertise will be used to drive the initial design of the API and analyses, but multiple application use-cases will also be used to inform further iterations. This use-case driven approach will result in a performance and power optimisation framework that allows programmers to optimise applications in domains where there is a genuine need.', 'language' => 'de'],
                ['content' => 'Low-power GPUs have become ubiquitous. They can be found in domains ranging from wearable and mobile computing, to automotive systems. With this ubiquity has come a wider range of opportunities of applications exploiting low-power GPUs, placing ever increasing demands on the expected performance and power eciency of the devices.
    Future low-power system-on-chips will have to provide higher performance and be able to support more complex applications, without using any additional power.
    The strict power limitations means, however, that these demands cannot be met through hardware improvements alone, but the software must fully exploit the available resources. Unfortunately, application developers are seriously hindered when creating low-power GPU software by the limited quality of current performance analysis tools. In low-power GPU contexts there is only a minimal amount of performance information, and essentially no power information, available to the programmer. As software becomes more complex it becomes increasingly unmanageable for programmers to optimise the software for low-power devices.
    This project proposes to aid the application developer in creating software for low-power GPUs by building on the results of the first LPGPU project by providing a complete performance and power analysis process for the programmer. This project will address all aspects of performance analysis, from hardware power and performance counters, to a framework that processes and visualises information from these counters, to applications that will be used as use-cases to drive the entire design. To access the new hardware performance counters a standardisable API will be produced to interface to a prototype hardware implementation. This will let the analysis and visualisation framework connect to any GPU driver that implements the API. The consortium’s expertise will be used to drive the initial design of the API and analyses, but multiple application use-cases will also be used to inform further iterations. This use-case driven approach will result in a performance and power optimisation framework that allows programmers to optimise applications in domains where there is a genuine need.', 'language' => 'en']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 10,
            'metadata_registry_id' => 3,
            'content' => ['2016-01-01'],
        ]);

        ProjectMetadata::create([
            'project_id' => 10,
            'metadata_registry_id' => 4,
            'content' => ['2018-06-30'],
        ]);

        ProjectMetadata::create([
            'project_id' => 10,
            'metadata_registry_id' => 5,
            'content' => [
                ['content' => 'In Progress', 'language' => 'en']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 10,
            'metadata_registry_id' => 6,
            'content' => [
                ['firstname' => 'Bernardus', 'lastname' => 'Juurlink', 'email' => '', 'uri' => '']
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 10,
            'metadata_registry_id' => 8,
            'content' => [
                'Think Silicon Ltd.',
                'Samsung Electronics',
                'Codeplay Software Ltd.',
                'SPIN DIGITAL VIDEO TECHNOLOGIES GMBH'
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 10,
            'metadata_registry_id' => 9,
            'content' => ['EU - Kommission der Europäischen Gemeinschaften'],
        ]);

        ProjectMetadata::create([
            'project_id' => 10,
            'metadata_registry_id' => 10,
            'content' => ['HORIZON 2020'],
        ]);

        ProjectMetadata::create([
            'project_id' => 10,
            'metadata_registry_id' => 11,
            'content' => ['688759'],
        ]);

        ProjectMetadata::create([
            'project_id' => 10,
            'metadata_registry_id' => 12,
            'content' => ['EU - Kommission der Europäischen Gemeinschaften'],
        ]);

        ProjectMetadata::create([
            'project_id' => 10,
            'metadata_registry_id' => 13,
            'content' => ['adela.westedt@tu-berlin.de'],
        ]);
    }
}