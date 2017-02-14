<plan>
     <project_number>{{ $plan->project_number }}</project_number>
     <institution>{{ $institution->name }}</institution>
     <data>
     @foreach( $sections as $section )            
        <section>
            <name>{{ $section->name }}</name>
            <fields>
                @foreach( $questions as $question )            
                    @if( $question->section_id == $section->id )
                        <field>
                            <id>{{ $question->id }}</id>                    
                            <question>{{ $question->text }}</question>
                            <?php
                            $answer = QuestionAnswerRel::getAnswer( $question, $plan );

                            if( is_array( $answer ) )
                            {                                        
                                foreach( $answer as $option_id )
                                {
                                    $option_data = QuestionOption::getOptionText( $option_id );
                                    echo '<answer>' . $option_data->text . '</answer>';
                                }                                        
                            }
                            else
                            {
                                echo '<answer>' . $answer . '</answer>';
                            }
                            ?></field>
                    @endif
                @endforeach                    
            </fields>
        </section>
     @endforeach
     </data>
</plan>