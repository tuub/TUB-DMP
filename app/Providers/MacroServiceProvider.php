<?php

namespace App\Providers;

use App\ContentType;
use App\ProjectMetadata;
use Illuminate\Support\ServiceProvider;
//use Collective\Html\HtmlServiceProvider;
use Illuminate\Html;
use App\Question;
use App\QuestionOption;
use App\Plan;
use App\Answer;

use Auth;
use Form;
//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Form::macro('answer', function( $survey, $question )
        {
            $answers = Answer::get($survey, $question, 'form');
            // Convert Answer Data according to content type
            $answers = Answer::formatForOutput($answers, $question->content_type);

            $macro = 'question_' . $question->content_type->identifier;

            $options = [
                'input_type'    => $question->content_type->input_type->identifier,
                'name'          => $question->id,
                'default'       => QuestionOption::getDefaultValue( $question ),
                'answers'       => $answers,
                'read_only'     => $question->readonly ? 'readonly' : ''
            ];

            Form::component( $macro, 'partials.components.form.' . $options['input_type'], ['question', 'name', 'answers' => null, 'default' => null, 'read_only' => null] );

            return Form::$macro($question, $options['name'], $options['answers'], $options['default'], $options['read_only']);
        });

        Form::macro('metadata', function( $project, $identifier )
        {
            $metadata_field = ProjectMetadata::getMetadataFieldByIdentifier($identifier);
            $values = $project->getMetadata($identifier);
            $label = $project->getMetadataLabel($identifier);
            $content_type = ContentType::where('id', $metadata_field->content_type_id)->first();
            //$content_type = ProjectMetadata::getMetadataContentType($identifier);
            $input_type = ProjectMetadata::getMetadataInputType($content_type);
            $is_multiple = $metadata_field->is_multiple;

            $macro = $content_type->identifier;

            $options = [
                'input_type'    => $input_type->identifier,
                'name'          => $identifier,
                'values'        => $values,
                'is_multiple'   => $is_multiple,
            ];

            Form::component( $macro, 'partials.components.form.metadata.' . $options['input_type'], ['project', 'label', 'name', 'is_multiple', 'values' => null] );

            return Form::$macro($project, $label, $options['name'], $options['is_multiple'], $options['values']);
        });

        if (false) {
            /* ID 3: Auswahlbox, einzeilig */
            Form::macro('question_select',
                function ($question, $input_name, Collection $answer = null, $default_value = null) {
                    $value = null;
                    foreach ($answer as $output) {
                        $value = $output->value;
                    }

                    $question_options = array('' => 'Please choose ...') + QuestionOption::where('question_id', '=',
                            $question->id)->pluck('text', 'text')->toArray();
                    $html = '';
                    $html .= $question->prepend;
                    $html .= Form::select($input_name . '[]', $question_options, $value,
                        array('data-type' => 'option', 'class' => 'question form-control'));
                    $html .= $question->append;
                    return $html;
                });

            /* ID 4: Auswahlbox, mehrzeilig */
            Form::macro('question_multiselect',
                function ($question, $input_name, Collection $answer = null, $default_value = null) {
                    $value = null;
                    foreach ($answer as $output) {
                        $value = $output->value;
                    }

                    $question_options = array('' => 'Please choose ...') + QuestionOption::where('question_id', '=',
                            $question['id'])->pluck('text', 'text');
                    $html = '';
                    $html .= $question->prepend;
                    //$html .= Form::hidden( $input_name . '[]', 'option' );
                    $html .= Form::select($input_name . '[]', $question_options, $value,
                        array('data-type' => 'option', 'class' => 'question form-control', 'multiple', 'size' => '5'));
                    $html .= $question->append;
                    return $html;
                });

            /* ID 5: Liste */
            Form::macro('question_list',
                function ($question, $input_name, Collection $answer = null, $default_value = null) {
                    $value = null;
                    if ($answer) {
                        $value = $answer->implode('value', ',');
                    }

                    $html = '';
                    $html .= $question->prepend;
                    $html .= Form::Text($input_name . '[]', $value, array(
                        'data-type' => 'list',
                        'class' => 'question form-control',
                        'title' => $question->guidance
                    ));
                    $html .= $question->append;
                    return $html;
                });

            /* ID 6: Checkboxen */
            Form::macro('question_checkboxes',
                function ($question, $input_name, Collection $answer = null, $default_value = null) {
                    $question_options = QuestionOption::where('question_id', '=', $question['id'])->pluck('text',
                        'text');
                    $html = '';
                    $html .= $question->prepend;

                    foreach ($question_options as $option_value => $option_label) {
                        $checked = false;
                        if (count($answer) > 0 && in_array($option_value, $answer)) {
                            $checked = true;
                        } else {
                            if (!is_null($default_value) && $option_value == $default_value) {
                                $checked = true;
                            }
                        }

                        $html .= '<div class="checkbox">';
                        $html .= '<label>';
                        //$html .= Form::hidden( $input_name . '[]', 'option' );
                        $html .= Form::checkbox($input_name . '[]', $option_value, $checked, array(
                            'data-type' => 'option',
                            'class' => 'question question-checkbox',
                            'autocomplete' => 'off',
                            'title' => $question->guidance
                        ));
                        $html .= $option_label;
                        $html .= '</label>';
                        $html .= '</div>';
                    }

                    $html .= $question->append;

                    return $html;
                });

            /* ID 7: Radiobuttons */
            Form::macro('question_radiobuttons',
                function ($question, $input_name, Collection $answer = null, $default_value = null) {
                    $question_options = QuestionOption::where('question_id', '=', $question->id)->pluck('text', 'text');

                    $value = null;
                    foreach ($answer as $output) {
                        $value = $output->value;
                    }

                    $html = '';

                    $html .= $question->prepend;

                    foreach ($question_options as $option_value => $option_label) {
                        $checked = false;

                        if (count($answer) > 0 && in_array($option_value, $value)) {
                            $checked = true;
                        }

                        if (count($answer) == 0) {
                            // check a default value
                            if (!is_null($default_value) && $option_value == $default_value) {
                                $checked = true;
                            }
                        }

                        $html .= '<div class="radio">';
                        $html .= '<label>';
                        //$html .= Form::hidden( $input_name . '[]', 'option' );
                        $html .= Form::radio($input_name . '[]', $option_value, $checked, array(
                            'data-type' => 'option',
                            'class' => 'question question-radio',
                            'autocomplete' => 'off',
                            'title' => $question->guidance
                        ));
                        $html .= $option_label;
                        if ($option_value == $default_value) {
                            $html .= ' ( Standardauswahl )';
                        }
                        $html .= '</label>';
                        $html .= '</div>';
                    }
                    $html .= $question->append;
                    return $html;
                });

            /* ID 8: Datumsfeld */
            Form::macro('question_date',
                function ($question, $input_name, Collection $answer = null, $default_value = null) {
                    $html = '';
                    $value = null;
                    foreach ($answer as $output) {
                        $value = $output->value;
                    }

                    $html .= $question->prepend;
                    //$html .= Form::hidden( $input_name . '[]', 'text' );
                    $html .= Form::Text($input_name . '[]', $value, array(
                        'data-type' => 'text',
                        'class' => 'question question-date form-control',
                        'title' => $question['guidance']
                    ));
                    $html .= $question->append;
                    return $html;
                });

            /* ID 9: Datumsbereich */
            Form::macro('question_daterange',
                function ($question, $input_name, Collection $answer = null, $default_value = null) {
                    if (count($answer) > 0) {
                        $date_from = $answer->get(0)->value;
                        $date_to = $answer->get(1)->value;
                    } else {
                        $date_from = null;
                        $date_to = null;
                    }

                    $html = '';
                    $html .= $question->prepend;
                    //$html .= Form::hidden( $input_name . '[]', 'range' );
                    $html .= Form::Text($input_name . '[]', $date_from, array(
                        'data-type' => 'range',
                        'class' => 'question question-daterange form-control',
                        'title' => $question->guidance
                    ));
                    $html .= ' - ';
                    $html .= Form::Text($input_name . '[]', $date_to, array(
                        'data-type' => 'range',
                        'class' => 'question question-daterange form-control',
                        'title' => $question->guidance
                    ));
                    $html .= $question->append;
                    return $html;
                });

            /* ID 10: Wertefeld */
            Form::macro('question_value',
                function ($question, $input_name, Collection $answer = null, $default_value = null) {
                    $param_array = explode('|', $question->value);
                    $value = null;

                    foreach ($answer as $output) {
                        $value = $output->value;
                    }

                    $html = '';
                    $html .= $question->prepend;
                    $html .= '&nbsp;&nbsp;';
                    //$html .= Form::hidden( $input_name . '[]', 'text' );
                    $html .= Form::Text($input_name . '[]', $answer, array(
                        'data-type' => 'text',
                        'class' => 'slider question',
                        'data-slider-min' => $param_array[0],
                        'data-slider-max' => $param_array[1],
                        'data-slider-step' => $param_array[2],
                        'data-slider-value' => $value,
                        'title' => $question->guidance
                    ));
                    $html .= '&nbsp;&nbsp;';
                    $html .= '<span class="slider-value">' . $answer . '</span>';
                    $html .= '&nbsp;&nbsp;';
                    $html .= $question->append;
                    return $html;
                });

            /* ID 11: Wertebereich */
            Form::macro('question_valuerange',
                function ($question, $input_name, Collection $answer = null, $default_value = null) {
                    $param_array = explode('|', $question->value);

                    if (count($answer) > 0) {
                        $alpha = $answer[0];
                        $omega = $answer[1];
                        $alpha_omega = $alpha . ',' . $omega;
                    } else {
                        $alpha = 0;
                        $omega = 5;
                        $alpha_omega = '0,5';
                    }
                    $html = '';
                    $html .= $question->prepend;
                    $html .= '&nbsp;&nbsp;';
                    //$html .= Form::hidden( $input_name . '[]', 'range' );
                    $html .= Form::Text(null, null, array(
                        'class' => 'slider-range',
                        'data-slider-min' => $param_array[0],
                        'data-slider-max' => $param_array[1],
                        'data-slider-step' => $param_array[2],
                        'data-slider-value' => '[' . $alpha_omega . ']',
                        'title' => $question->guidance
                    ));
                    $html .= '&nbsp;&nbsp;';
                    $html .= Form::hidden($input_name . '[]', $alpha,
                        array('data-type' => 'range', 'class' => 'question slider-range-input-alpha'));
                    $html .= Form::hidden($input_name . '[]', $omega,
                        array('data-type' => 'range', 'class' => 'question slider-range-input-omega'));
                    $html .= '<span class="slider-range-display-alpha">' . $alpha . '</span>';
                    $html .= ' - ';
                    $html .= '<span class="slider-range-display-omega">' . $omega . '</span>';
                    $html .= '&nbsp;&nbsp;';
                    $html .= $question->append;
                    return $html;
                });

            /* ID 12: Ja / Nein */
            Form::macro('question_boolean',
                function ($question, $input_name, Collection $answer = null, $default_value = null) {
                    $question_options = QuestionOption::where('question_id', '=', $question['id'])->pluck('text', 'id');
                    $html = '';
                    $html .= $question->prepend;
                    foreach ($question_options as $option_value => $option_label) {
                        $checked = false;
                        if (count($answer) > 0 && in_array($option_value, $answer)) {
                            $checked = true;
                        }
                        if (count($answer) == 0) {
                            // check a default value
                            if (!is_null($default_value) && $option_value == $default_value) {
                                $checked = true;
                            }
                        }
                        $html .= '<div class="radio">';
                        $html .= '<label>';
                        //$html .= Form::hidden($input_name . '[]', 'option');
                        $html .= Form::radio($input_name . '[]', $option_value, $checked, array(
                            'data-type' => 'option',
                            'class' => 'question question-radio',
                            'autocomplete' => 'off',
                            'title' => $question->guidance
                        ));
                        $html .= $option_label;
                        if ($option_value == $default_value) {
                            $html .= ' ( Standardauswahl )';
                        }
                        $html .= '</label>';
                        $html .= '</div>';
                    }
                    $html .= $question->append;
                    return $html;
                });

            /* ID 99: Text */
            Form::macro('question_headline',
                function ($question, $input_name, Collection $answer = null, $default_value = null) {
                    $value = null;
                    foreach ($answer as $output) {
                        $value = $output->value;
                    }
                    $html = $value;
                    return $html;
                });
        }


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
