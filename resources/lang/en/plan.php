<?php
declare(strict_types=1);

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
    'my-plans-header' => 'My Data Management Plans',

    'create' => [
        'title' => 'Create DMP',
        'description' => '',
        'input' => [
            'title' => [
                'label' => 'DMP Title',
                'placeholder' => 'e.g. My Data Management Plan',
                'default' => 'Data Management Plan'
            ],
            'template' => [
                'label' => 'Template',
                'placeholder' => ''
            ],
            'version' => [
                'label' => 'Version Description',
                'placeholder' => 'e.g. First DMP version',
                'default' => '1.0'
            ]
        ],
        'button' => [
            'cancel' => 'Cancel',
            'submit' => 'Create'
        ]
    ],

    'edit' => [
        'title' => 'Edit DMP Metadata',
        'description' => '',
        'input' => [
            'title' => [
                'label' => 'DMP Title',
                'placeholder' => ''
            ],
            'version' => [
                'label' => 'Version Description',
                'placeholder' => 'e.g. First DMP version'
            ]
        ],
        'button' => [
            'cancel' => 'Cancel',
            'submit' => 'Save'
        ]
    ],

    'email' => [
        'title' => 'Email DMP',
        'description' => 'Let your colleagues know about your DMP.',
        'input' => [
            'name' => [
                'label' => 'Name',
                'placeholder' => 'e.g. John Doe'
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'e.g. john.doe@example.org'
            ],
            'message' => [
                'label' => 'Your Message (optional)',
                'placeholder' => ''
            ]
        ],
        'button' => [
            'cancel' => 'Cancel',
            'submit' => 'Send Email'
        ]
    ],

    'delete' => [
        'title' => 'Delete DMP',
        'description' => 'Are you sure?',
        'button' => [
            'cancel' => 'Cancel',
            'submit' => 'OK'
        ]
    ],

    'export' => [
        'title' => 'Export DMP',
        'description' => 'Choose Export Format ...',
        'format' => [
            'pdf' => [
                'label' => 'PDF',
                'description' => 'Exports your DMP with all automatically and manually provided data.',
                'link'  => 'Open / Download'
            ]
        ],
        'button' => [
            'cancel' => 'Cancel'
        ]
    ],

    'snapshot' => [
        'title' => 'Create Snapshot & New Version',
        'description' => 'During the several stages of your research project, you should review your DMP for updated info and create new versions to document and critically reflect the research process.',
        'danger' => 'Once you create a snapshot of your DMP, you will not be able to edit the data of your current version. By default, a new version will be created for you for further editing.',
        'input' => [
            'title' => [
                'label' => 'DMP Title',
                'placeholder' => ''
            ],
            'version' => [
                'label' => 'Version Description',
                'placeholder' => 'e.g. First DMP version'
            ],
            'clone_current' => [
                'label' => 'Create new version from current plan'
            ]
        ],
        'button' => [
            'cancel' => 'Cancel',
            'submit' => 'Continue'
        ]
    ],

    'info' => [
        'button' => [
            'edit' => 'Edit',
            'show' => 'View',
            'email' => 'Email to Colleague',
            'export' => 'Export',
            'snapshot' => 'Create Snapshot & New Version',
            'delete' => 'Delete'
        ]
    ]

];
