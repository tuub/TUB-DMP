<?php

return array(


    'pdf' => array(
        'enabled' => true,
        //'binary'  => 'xvfb-run /usr/bin/wkhtmltopdf',
        'binary' => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
        //'binary'  => '/usr/local/bin/wkhtmltopdf',
        'timeout' => false,
        'options' => array(
            'encoding' => 'utf-8',
        ),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        //'binary'  => 'xvfb-run /usr/bin/wkhtmltoimage',
        'binary'  => '/usr/local/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
);
