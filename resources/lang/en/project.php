<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dashboard Language Lines
    |--------------------------------------------------------------------------
    |
    |
    |
    |
    |
    */
    'request' => [
        'title' => 'Request new Project DMP',
        'subtitle' => 'For privacy and legal reasons, we have to check manually your connection to the provided research project.',
        'label' => [
            'identifier' => 'Project ID',
            'name' => 'Your name',
            'email' => 'Your email address',
            'tub_om' => 'TU-Ordnungsmerkmal',
            'institution_identifier' => 'TU-Kostenstelle',
            'contact_email' => 'Institutional email address (required)',
            'message' => 'Your message (optional)',
        ],
        'help' => [
            'identifier' => 'Please provide a TUB project ID in order to import project metadata. Otherwise we provide you with a random project identifier.',
            'contact_email' => 'Please provide a neutral email address (e.g. secretary\'s office) of your institution (preferably Fachgebiet)',
        ],
        'placeholder' => [
            'name' => 'John Doe',
            'email' => 'john.doe@example.org',
            'tub_om' => '12345',
            'institution_identifier' => '4600100100',
            'contact_email' => 'sekretariat@...',
        ],
        'button' => [
            'submit' => 'Submit to SZF Team',
            'cancel' => 'Cancel',
        ]
    ],
    'show' => [
        'title' => 'Show Project DMP Metadata',
        'plan' => 'Plan',
        'sub_project' => 'Sub-Project',
        'button' => [
            'submit' => 'OK',
        ]
    ],
    'edit' => [
        'title' => 'Edit Project DMP Metadata for ',
        'button' => [
            'submit' => 'Update',
            'cancel' => 'Cancel',
        ]

    ],
    'infocard' => [
        'status' => [
            'label' => 'Status',
        ],
        'import' => [
            'label' => 'Data Import',
            'no_datasource' => 'None',
        ],
        'button' => [
            'show' => 'More Info',
            'edit' => 'Edit Project Metadata',
            'import' => 'Import from Datasource',
            'plans' => 'Plans',
        ],
    ],
    'status' => [
        'not_startet' => 'Not started',
        'running' => 'Running',
        'ended' => 'Ended',
        'unknown' => 'Unknown',
    ],
    'metadata' => [
        'identifier' => 'Project Identifier',
        'title' => 'Project Title',
        'abstract' => 'Project Description',
        'duration' => 'Project Duration',
        'begin' => 'Project Begin',
        'end' => 'Project End',
        'stage' => 'Project Stage',
        'leader' => 'Principal Investigator',
        'member' => 'Other Principal Investigator',
        'partner' => 'External Project Partner',
        'funding_source' => 'Funding Source',
        'funding_program' => 'Funding Program',
        'grant_reference_number' => 'Grant Reference Number',
        'project_management_organisation' => 'Project Management Organisation',
        'project_data_contact' => 'Project Data Contact',
    ]
];
