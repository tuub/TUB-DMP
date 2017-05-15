<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        @if(false )
            {!! HTML::style('css/app.css') !!}
        @endif

        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro|Source+Serif+Pro" rel="stylesheet">

        <style type = "text/css">


            * {
                outline: 0px #336699 dotted;
            }

            div {
                font-family: 'Source Serif Pro', Arial, Geneva, Helvetica, Verdana, sans-serif;
            }

            .text-center {
                text-align: center;
            }

            a {
                text-decoration: none !important;
            }

            /*
            div.page {
                overflow: hidden;
                page-break-after: always;
                page-break-inside: avoid;
                padding-top: 0mm;
            }

            div.page p {
                widows: 15;
                orphans: 15;
                page-break-inside: avoid;
            }

            div.section {
                page-break-inside: avoid;
                display: inline-block;
            }
*/


            div.page  {
                overflow: hidden;
                page-break-after: always;
                padding-top: 0mm;
            }

            div.question {
                widows: 15;
                orphans: 15;
            }

            div.section-title {
                page-break-after: avoid;
            }


        </style>

    </head>
    <body>
        <script type="text/php">
        if (isset($pdf)) {
            //$footer = $pdf->open_object();
            $x = 540;
            $y = 740;
            $text = '{PAGE_NUM}/{PAGE_COUNT}';
            $font = null;
            $size = 10;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
        </script>
        <div class="container page">
            <br/>
            <div class="row text-center">
                {!! HTML::image('images/logo-tu.png', 'TU Berlin', array('class' => 'thumb', 'title' => 'TU Berlin', 'style' => 'height: 50px;')) !!}
                <h1>{{ $plan->title }}</h1>
            </div>
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
            <br/><br/>
            <div class="row">
                @if( $project->getMetadata('project_stage') )
                    <strong>{{ str_plural($project->getMetadataLabel('project_stage'), $project->getMetadata('project_stage')->count()) }}</strong>
                    @foreach( $project->getMetadata('project_stage') as $project_stage )
                            "{{ $project_stage['content'] }}"<br/>
                        @endforeach
                    @endif

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
            <br/><br/>
            <div class="row">
                <!--<div class="col-xs-offset-6 col-xs-12 text-justify">-->
                    <p>
                        Copyright information: The above plan creator(s) have agreed that others may use
                        as much of the text of this plan as they would like in their own plans, and customize
                        it as necessary. You do not need to credit the creators as the source of the
                        language used, but using any of their plan's text does not imply that the creator(s)
                        endorse, or have any relationship to, your project or proposal.
                    </p>
                <!--</div>-->
            </div>
        </div>

        @if( $project->getMetadata('abstract') )
            <div class="container page">
                <div class="row">
                    <strong>
                        {{ str_plural($project->getMetadataLabel('abstract'), $project->getMetadata('abstract')->count()) }}
                    </strong>
                    <br/>
                    @foreach($project->getMetadata('abstract') as $abstract)
                        {!! nl2br($abstract['content']) !!}
                        <br/><br/>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="container page survey">
            @foreach($survey->template->sections as $section)
                @unless($section->isEmpty($survey))
                    <div class="section">
                        <p>
                            <div class="row section-title">
                                <h3>{{ $section->name }}</h3>
                            </div>

                            @foreach($section->questions as $question)
                                @php
                                    $answer = \App\Answer::get($survey, $question, 'html');
                                @endphp

                                @unless(is_null($answer))
                                    <div class="row question">
                                        <strong>
                                            @if(is_null($question->output_text))
                                                {{ $question->text }}
                                            @else
                                                {{ $question->output_text }}
                                            @endif
                                        </strong>
                                        <br/>
                                        {!! $answer  !!}
                                    </div>
                                    <br/>
                                @endunless

                            @endforeach
                        </p>
                    </div>
                @endunless
            @endforeach
        </div>

    </body>
</html>