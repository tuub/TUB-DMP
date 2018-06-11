<html>
    <head>
        <title>{{$survey->template->name}} :: {{ $project->identifier }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="author" content="{{ auth()->user()->email }}">
        <meta name="keywords" content="dmp">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro|Source+Serif+Pro" rel="stylesheet">
        {!! HTML::style('css/pdf.css') !!}
    </head>
    <body>
        <script type="text/php">

        /* SETUP THE LOGO */
        if (strlen("{{$survey->template->logo_file}}") > 0) {
            $template_logo_version = "{{$survey->template->getLogoFile('header')}}";
            $template_logo_file = new App\Library\ImageFile($template_logo_version);

            $GLOBALS["template_logo"] = $template_logo_file->getFullPath();
            $GLOBALS["template_logo_x"] = $template_logo_file->getWidth();
            $GLOBALS["template_logo_y"] = $template_logo_file->getHeight();
        }

        if (isset($pdf)) {

            //$GLOBALS['start_pages'] = array( );
            //$GLOBALS['current_start_page'] = null;
            //$GLOBALS['show_page_numbers'] = false;
            //$GLOBALS['current_page_number'] = 1;

            //$GLOBALS["toc"] = [];
            //$GLOBALS["front_page"] = $GLOBALS["start_page"] - 2;
            //$GLOBALS["toc_page"] = $GLOBALS["start_page"] - 1;

            $GLOBALS["front_page"] = 1;
            $GLOBALS["start_page"] = 2;


            /* THE HEADER */
            $header = $pdf->open_object();
            $pdf->page_script('

                /* SETUP */
                $w = $pdf->get_width();
                $h = $pdf->get_height();
                $first_page = 3;

                /* HEADER LOGO */
                if (isset($GLOBALS["template_logo"])) {
                    $logo_file = $GLOBALS["template_logo"];
                    $logo_x = $GLOBALS["template_logo_x"] / 5;
                    $logo_y = $GLOBALS["template_logo_y"] / 5;
                    $logo_pos_x = $w - $logo_x - 60;
                    $logo_pos_y = 15;
                    $logo_res = "";
                }

                /* HEADER TEXT */
                $text_pos_x = 55;
                $text_pos_y = 25;
                $text_content = "{{$survey->template->name}} - {{$survey->plan->title}}";
                $text_font = $fontMetrics->getFont("helvetica", "bold");
                $text_size = 10;
                $text_color = [0,0,0];

                /* BRINGING IT ALL BACK HOME */
                if ($PAGE_NUM >= $GLOBALS["start_page"]) {

                    $pdf->text($text_pos_x, $text_pos_y, "$text_content", $text_font, $text_size, $text_color);

                    if (isset($GLOBALS["template_logo"])) {
                        $pdf->image("$logo_file", $logo_pos_x, $logo_pos_y, $logo_x, $logo_y);
                    }

                }
            ');

            $pdf->close_object();
            $pdf->add_object($header, 'all');

            /* THE FOOTER */
            $footer = $pdf->open_object();
            $pdf->page_script('

                /* SETUP */
                $w = $pdf->get_width();
                $h = $pdf->get_height();

                /* FOOTER LINE */
                $line_pos_x_start = 55;
                $line_pos_y_start = $h - 40;
                $line_pos_x_end = $w - 60;
                $line_pos_y_end = $line_pos_y_start;
                $line_color = [0,0,0];
                $line_width = 1;
                $line_style = "";

                /* FOOTER LOGO */
                $logo_file = "images/logo-dmp-small.png";
                $logo_pos_x = 55;
                $logo_pos_y = $h - 35;
                $logo_x = 150 / 4.5;
                $logo_y = 74 / 4.5;
                $logo_res = "";

                /* FOOTER TEXT */
                $text_pos_x = 55;
                $text_pos_y = $h - 35;
                $text_content = "{{$survey->plan->title}}";
                $text_font = $fontMetrics->getFont("helvetica", "bold");
                $text_size = 10;
                $text_color = [0,0,0];

                /* FOOTER PAGE NUMBER */
                $page_no = $PAGE_NUM - $GLOBALS["start_page"] + 1;
                $page_count = $PAGE_COUNT - $GLOBALS["start_page"] + 1;

                $pagenumber_pos_x = $w - 73;
                $pagenumber_pos_y = $h - 35;
                $pagenumber_content = $page_no . "/" . $page_count;
                $pagenumber_font = $fontMetrics->getFont("helvetica", "bold");
                $pagenumber_size = 10;
                $pagenumber_color = [0,0,0];

                /* BRINGING IT ALL BACK HOME */
                if ($PAGE_NUM >= $GLOBALS["start_page"]) {
                    $pdf->line($line_pos_x_start, $line_pos_y_start, $line_pos_x_end, $line_pos_y_end, $line_color, $line_width);
                    $pdf->text($pagenumber_pos_x, $pagenumber_pos_y, "$pagenumber_content", $pagenumber_font, $pagenumber_size, $pagenumber_color);
                    //$pdf->text($text_pos_x, $text_pos_y, "$text_content", $text_font, $text_size, $text_color);
                    //$pdf->image("$logo_file", $logo_pos_x, $logo_pos_y, $logo_x, $logo_y);
                }
            ');

            $pdf->close_object();
            $pdf->add_object($footer, 'all');
        }
        </script>

        <div class="frontpage" id="title">
            <h2>{{ $survey->template->name }}</h2>
            <h2>{{ $plan->title }}</h2>
            <strong>Project ID</strong><br/>
            {{ $project->identifier }}<br/><br/>
        </div>

        <div class="frontpage" id="date">
            @date(\Carbon\Carbon::now())
        </div>


        <div class="frontpage" id="generator">
            This DMP was created with <a href="{!! getenv('APP_URL') !!}" target="_blank">TUB-DMP</a>.
        </div>

        <div class="page"></div>

        @if(false)
            <div class="page">
                <script type="text/php">
                    if (isset($pdf)) {

                        $pdf->page_script('
                            if ($PAGE_NUM == $GLOBALS["toc_page"]) {

                                /* TOC */

                                $toc_header_pos_x = 55;
                                $toc_header_pos_y = 100;
                                $toc_header_content = "Table of Contents";
                                $toc_header_font = $fontMetrics->getFont("helvetica", "bold");
                                $toc_header_size = 14;
                                $toc_header_color = [0,0,0];

                                $toc_pos_x = 55;
                                $toc_pos_y = $toc_header_pos_y + 50;
                                $toc_font = $fontMetrics->getFont("helvetica", "normal");
                                $toc_size = 11;
                                $toc_color = [0,0,0];

                                $pdf->text($toc_header_pos_x, $toc_header_pos_y, $toc_header_content, $toc_header_font, $toc_header_size, $toc_header_color);

                                //$content = var_dump($GLOBALS);

                                //$pdf->text($toc_header_pos_x, $toc_header_pos_y + 60, "$content", $toc_header_font, 7, $toc_header_color);

                                foreach($GLOBALS["toc"] as $page_number => $section_title) {

                                    $pdf->text($toc_pos_x, $toc_pos_y, "$section_title ---------------------- $page_number", $toc_font, $toc_size, $toc_color);
                                    $toc_pos_y += 20;
                                }
                            }
                        ');
                    }
                </script>
            </div>
        @endif

        @if ($project->metadata()->count() > 0)
            <div class="page">
                <script type="text/php">
                    if (isset($pdf)) {
                        $GLOBALS['toc'][$pdf->get_page_number() - ($GLOBALS["start_page"] - 1)] = "Project Metadata";
                    }
                </script>

                <div class="row metadata">
                    <h2>
                        Project Metadata
                    </h2>

                    @if( $project->getMetadata('title') )
                        <strong>{{ str_plural($project->getMetadataLabel('title'), $project->getMetadata('title')->count()) }}</strong>
                        <br/>
                        @foreach( $project->getMetadata('title') as $title )
                            "{{ $title['content'] }}"<br/>
                        @endforeach
                        <br/>
                    @endif

                    @if( $project->getMetadata('leader') )
                        <strong>{{ str_plural($project->getMetadataLabel('leader'), $project->getMetadata('leader')->count()) }}</strong>
                        <br/>
                        @foreach( $project->getMetadata('leader') as $leader )
                            {!! \App\ProjectMetadata::getProjectMemberOutput($leader) !!}<br/>
                        @endforeach
                        <br/>
                    @endif

                    @if( $project->getMetadata('member') )
                        <strong>{{ str_plural($project->getMetadataLabel('member'), $project->getMetadata('member')->count()) }}</strong>
                        <br/>
                        @foreach( $project->getMetadata('member') as $member )
                            {!! \App\ProjectMetadata::getProjectMemberOutput($member) !!}<br/>
                        @endforeach
                        <br/>
                    @endif

                    @if( $project->getMetadata('begin') )
                        <strong>Duration</strong>
                        <br/>
                        @foreach( $project->getMetadata('begin') as $begin )
                            @date($begin) -
                            @if( $project->getMetadata('end') )
                                @foreach( $project->getMetadata('end') as $end )
                                    @date($end)
                                @endforeach
                            @endif
                        @endforeach
                        <br/><br/>
                    @endif

                    @if( $project->getMetadata('project_stage') )
                        <strong>{{ str_plural($project->getMetadataLabel('project_stage'), $project->getMetadata('project_stage')->count()) }}</strong>
                        <br/>
                        @foreach( $project->getMetadata('project_stage') as $project_stage )
                            "{{ $project_stage['content'] }}"<br/>
                        @endforeach
                        <br/><br/>
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

                    @if( $project->getMetadata('partner') )
                        <strong>{{ str_plural($project->getMetadataLabel('partner'), $project->getMetadata('partner')->count()) }}</strong>
                        <br/>
                        @foreach($project->getMetadata('partner') as $partner)
                            {!! $partner !!}<br/>
                        @endforeach
                        <br/>
                    @endif

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
            </div>
        @endif

        @if( $project->getMetadata('abstract') )
            <div class="container page">
                <script type="text/php">
                    if (isset($pdf)) {
                        $GLOBALS['toc'][$pdf->get_page_number() - ($GLOBALS["start_page"] - 1)] = "Project Description";
                    }
                </script>
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
        @if($project->hasParent())
            <div class="container page">
                <script type="text/php">
                    if (isset($pdf)) {
                        $GLOBALS['toc'][$pdf->get_page_number() - 1] = "Parent Project Information";
                    }
                </script>
                <div class="parent-project">
                    <div class="row">
                        <h2>
                            Parent Project
                        </h2>

                        <div class="alert-xs alert-info">
                            <p>
                                <label>{{ $project->getMetadataLabel('identifier') }}:</label>
                                {{ $project->getParent()->identifier }}
                            </p>
                            <p>
                                @if( $project->getParent()->getMetadata('title') )
                                    <label>{{ str_plural($project->getParent()->getMetadataLabel('title'), $project->getParent()->getMetadata('title')->count()) }}:</label>
                                    <br/>
                                    @foreach( $project->getParent()->getMetadata('title') as $title )
                                        {{ strtoupper($title['language']) }}: {{ $title['content'] }}
                                        @unless( $loop->last )
                                            <br/>
                                        @endunless
                                    @endforeach
                                    <br/><br/>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="container page survey">
            @foreach($survey->template->sections()->active()->ordered()->get() as $section)
                @unless($section->isEmpty($survey))
                    <div class="section">
                        <script type="text/php">
                            if (isset($pdf)) {
                                $GLOBALS['toc'][$pdf->get_page_number() - 1] = "@if($section->export_keynumber){{$section->keynumber}} @endif{{ $section->name }}";
                            }
                        </script>
                        <div class="row section-title nobreak">
                            <h3>
                                @if($section->export_keynumber)
                                    {{ $section->keynumber }}
                                @endif
                                {{ $section->name }}
                            </h3>
                        </div>

                        @foreach($section->questions()->active()->ordered()->get() as $question)

                            @if ($question->isRoot())
                                @include('partials.question.pdf', [$survey, $question])
                            @endif

                        @endforeach
                    </div>
                @endunless
            @endforeach
        </div></body></html>