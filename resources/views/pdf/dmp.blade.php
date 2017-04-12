<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        {!! HTML::style('css/app.css') !!}

        <style type = "text/css">

            * {
                outline: 0px #336699 dotted;
            }

            div { font-family: Arial, Geneva, Helvetica, Verdana, sans-serif; }

            div.page
            {
                overflow: hidden;
                page-break-after: always;
                page-break-inside: avoid;
                widows: 15;
                orphans: 3;
                padding-top: 15mm;
            }
        </style>

    </head>
    <body>
        <div class="container page">
            <br/><br/><br/>
            <div class="row text-center">
                <h1>{{ $plan->title }}</h1>
            </div>
            <br/><br/>
            <div class="row">
                <div class="col-xs-offset-6 col-xs-12 text-center">
                    <h4>
                        @if( $project->getMetadata('title') )
                            @foreach( $project->getMetadata('title') as $title )
                                "{{ $title['content'] }}"<br/><br/>
                            @endforeach
                        @endif
                    </h4>
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

                    <strong>Project ID</strong><br/>
                    {{ $project->identifier }}<br/><br/>
                    @if( $project->getMetadata('leader') )
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
            <br/><br/><br/><br/>
            <div class="row">
                @if( $project->getMetadata('grant_reference_number') )
                    <strong>{{ str_plural($project->getMetadataLabel('grant_reference_number'), $project->getMetadata('grant_reference_number')->count()) }}</strong>
                    <br/>
                    {!! $project->getMetadata('grant_reference_number')->first() !!}
                    <br/><br/>
                @endif

                @if( $project->getMetadata('funding_source') )
                    <strong>{{ str_plural($project->getMetadataLabel('funding_source'), $project->getMetadata('funding_source')->count()) }}</strong>
                    <br/>
                    @foreach($project->getMetadata('funding_source') as $funding_source)
                        {!! $funding_source !!}<br/>
                    @endforeach
                    <br/>
                @endif

                @if( $project->getMetadata('funding_program') )
                    <strong>{{ str_plural($project->getMetadataLabel('funding_program'), $project->getMetadata('funding_program')->count()) }}</strong>
                    <br/>
                    @foreach($project->getMetadata('funding_program') as $funding_program)
                        {!! $funding_program !!}<br/>
                    @endforeach
                    <br/>
                @endif
            </div>
            <div class="row">
                @if( $project->getMetadata('partner') )
                    <strong>{{ str_plural($project->getMetadataLabel('partner'), $project->getMetadata('partner')->count()) }}</strong>
                    <br/>
                    @foreach($project->getMetadata('partner') as $partner)
                        {!! $partner !!}<br/>
                    @endforeach
                    <br/>
                @endif
            </div>
            <div class="row">
                @if( $project->getMetadata('project_management_organisation') )
                    <strong>{{ str_plural($project->getMetadataLabel('project_management_organisation'), $project->getMetadata('project_management_organisation')->count()) }}</strong>
                    <br/>
                    @foreach($project->getMetadata('project_management_organisation') as $project_management_organisation)
                        {!! $project_management_organisation !!}<br/>
                    @endforeach
                    <br/>
                @endif

                @if( $project->getMetadata('project_data_contact') )
                    <strong>{{ str_plural($project->getMetadataLabel('project_data_contact'), $project->getMetadata('project_data_contact')->count()) }}</strong>
                    <br/>
                        @foreach($project->getMetadata('project_data_contact') as $project_data_contact)
                            {!! $project_data_contact !!}<br/>
                        @endforeach
                    <br/>
                @endif
            </div>
            <br/><br/><br/><br/>
            <div class="row">
                <div class="col-xs-offset-6 col-xs-12 text-justify">
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
            <div class="row">
                @if( $project->getMetadata('abstract') )
                    <strong>
                        {{ str_plural($project->getMetadataLabel('abstract'), $project->getMetadata('abstract')->count()) }}
                    </strong>
                    <br/>
                    @foreach($project->getMetadata('abstract') as $abstract)
                        {!! nl2br($abstract['content']) !!}
                        <br/><br/>
                    @endforeach
                @endif
            </div>
        </div>



        <div class="container page">
            @foreach($survey->template->sections as $section)

                <h4>{{ $section->name }}</h4>

                @foreach($section->questions as $question)

                <div class="row">
                    {{ $question->text }}
                </div>
                @endforeach

            @endforeach
        </div>

    </body>
</html>



    </body>
</html>