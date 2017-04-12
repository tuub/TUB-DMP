<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        {!! HTML::style('css/app.css') !!}

        <style type = "text/css">

            * {
                outline: 1px #336699 dotted;
            }

            div { font-family: Arial, Geneva, Helvetica, Verdana, sans-serif; }

            div.container {
                widows: 15;
            }

            div.page
            {
                overflow: hidden;
                page-break-after: always;
                page-break-inside: avoid;
            }
        </style>

    </head>
    <body>
        <div class="container page">
            <div class="row text-center">
                <h1>{{ $plan->title }}</h1>
            </div>
            <br/><br/>
            <div class="row">
                <div class="col-md-offset-6 col-md-12 text-center">
                    for<br/><br/>
                    @if( $project->getMetadata('title') )
                        @foreach( $project->getMetadata('title') as $title )
                            "{{ $title['content'] }}"<br/><br/>
                        @endforeach
                    @endif
                    ({{ $project->identifier }})<br/><br/>
                    @if( $project->getMetadata('begin') )
                        @foreach( $project->getMetadata('begin') as $begin )
                            @date($begin) -
                            @if( $project->getMetadata('end') )
                                @foreach( $project->getMetadata('end') as $end )
                                    @date($end)
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                    <br/><br/>
                    @if( $project->getMetadata('leader') )
                        <b>Principal Investigators:</b>
                        @foreach( $project->getMetadata('leader') as $leader )
                            {!! \App\ProjectMetadata::getProjectMemberOutput($leader) !!}<br/>
                        @endforeach
                    @endif
                    @if( $project->getMetadata('member') )
                        @foreach( $project->getMetadata('member') as $member )
                            {!! \App\ProjectMetadata::getProjectMemberOutput($member) !!}<br/>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-offset-6 col-md-12 text-justify">
                    <p>
                        Copyright information: The above plan creator(s) have agreed that others may use
                        as much of the text of this plan as they would like in their own plans, and customize
                        it as necessary. You do not need to credit the creators as the source of the
                        language used, but using any of their plan's text does not imply that the creator(s)
                        endorse, or have any relationship to, your project or proposal.
                    </p>
                </div>
            </div>
        </div>
        <div class="container page">
            @foreach($survey->template->questions as $question)
                <div class="row">
                    {{ $question->text }}
                </div>
            @endforeach
        </div>

    </body>
</html>



    </body>
</html>