<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        {!! HTML::style('css/app.css') !!}

        <style type = "text/css">

            * {
                outline: 0px #336699 dotted;
            }

            div { font-family: Arial, Geneva, Helvetica, Verdana, sans-serif; }
        </style>


    </head>
    <body style="margin:0; padding:0;">
    <div style="text-align: center;">
        {!! HTML::image('images/logo-tu.png', 'TU Berlin', array('class' => '', 'title' => 'TU Berlin', 'style' => 'height: 5mm;')) !!}
        &nbsp;&nbsp;
        {{ $plan->project->identifier }} - {{ $plan->title }}
    </div>
    </body>
</html>
