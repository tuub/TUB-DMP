<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!-- PDF Styles
================================================== -->        
{{ HTML::style('css/pdf.css'); }}        

<body>
<div class="pdf-container">
    <!-- Since floats are not stable in DomPDF we'll use good old tables :) -->
    <table style="width: 100%;">
        <tr>
            <td>
                <img id="logo-tu" src="{{ asset('images/logo-tu.png') }}" alt="Logo TU" title="Logo TU" />            
            </td>
            <td>
                <h1 style="display: inline;">Datenmanagementplan</h1>
                <br/>
                Projekt {{ $plan->project_number }}
            </td>
            <td>
                <img id="logo-szf" src="{{ asset('images/logo-szf.png') }}" alt="Logo SZF" title="Logo SZF" />                
            </td>
        </tr>        
    </table>

    <p>
                    Creator(s): {{ $plan_author }}<br/>
                    Institution: {{ $plan_institution }}<br/>
                    Last modified: {{ $plan_date }}
                </p>
                <p>
                    Copyright information: The above plan creator(s) have agreed that others may use
                    as much of the text of this plan as they would like in their own plans, and customize
                    it as necessary. You do not need to credit the creators as the source of the
                    language used, but using any of their plan's text does not imply that the creator(s)
                    endorse, or have any relationship to, your project or proposal.
                </p>
    
    <!--<h1>{{-- $plan->name --}}</h1>-->

    <ol id="plan-toc">
    @foreach( $sections as $section )            
        <li><a href="#{{ $section->id }}">{{ $section->name }}</a></li>
    @endforeach
    </ol>
    
    @foreach( $sections as $section )            
        <div class="new-page">
            <div class="section-header">
                <h3><a name="{{ $section->id }}">{{ $section->keynumber }}. {{ $section->name }}</a></h3>
            </div>
            @foreach( $questions as $question )
                @if( $question->section_id == $section->id )
                    <div class="question-answer-set">
		        <p>
                            <span class="question-text">
                                {{ $section->keynumber }}.{{ $question->keynumber }}                        
                                {{ $question->text }}
                            </span>
                            <br/>
                            <span class="answer-text">
                                <strong>
                                    
                                    <?php
                                    $answer = QuestionAnswerRel::getAnswer( $question, $plan );
                                    
                                    if( is_array( $answer ) )
                                    {                                        
                                        foreach( $answer as $option_id )
                                        {
                                            $option_data = QuestionOption::getOptionText( $option_id );
                                            echo '<li><span class="answer-text">' . $option_data->text . '</span></li>';
                                        }                                        
                                    }
                                    else
                                    {
                                        echo $answer;                                        
                                    }
                                    ?>
                                    
                                </strong>  
                            </span>
                        </p>
		    </div>
                @endif
            @endforeach
        </div>
    @endforeach
</div>

</body>
