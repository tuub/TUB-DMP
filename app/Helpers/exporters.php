<?php

use App\QuestionAnswerRelation;
use App\Section;

//use PDF;



class Exporters
{
    public static function getPDF( $plan, $download )
    {
        $options = [
            'page_orientation' => 'P',
            'page_unit'        => 'mm',
            'page_format'      => 'A4',
            'border'           => 0,
            'alignment'        => 'J',
            'page_margin'      => [ 'left' => 20, 'top' => 20 ],
            'toc'              => [ 'font' => 'helvetica', 'style' => '', 'size' => 12 ],
            'section'          => [ 'font' => 'helvetica', 'style' => 'B', 'size' => 14 ],
            'question'         => [
                'font'            => 'helvetica',
                'style'           => 'B',
                'size'            => 10,
                'parent_margin'   => 0,
                'children_margin' => 0
            ],
            'answer'           => [
                'font'            => 'helvetica',
                'style'           => '',
                'size'            => 10,
                'parent_margin'   => 4,
                'children_margin' => 4
            ]
        ];

        $metadata = [
            'title'   => 'Data Management Plan for TUB Project ' . $plan->project_number . ' / Version ' . $plan->version,
            'author'  => Auth::user()->real_name,
            'creator' => 'TUB-DMP'
        ];

        $pdf = new PDF( $options['page_orientation'], $options['page_unit'], $options['page_format'] );

        //$pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, 'marks', 'header string');

        //$fontname = TCPDF_FONTS::addTTFfont('/srv/tub-dmp/public/fonts/arial.ttf', 'TrueTypeUnicode', '', 32);
        //$pdf->SetFont('arial', '', 20, '', 'false');

        //$pdf->SetCreator(PDF_CREATOR);
        $pdf->SetCreator( $metadata['creator'] );
        $pdf->SetAuthor( $metadata['author'] );
        $pdf->SetTitle( $metadata['title'] );
        //$pdf->SetSubject('TCPDF Tutorial');
        //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetMargins( $options['page_margin']['left'], $options['page_margin']['top'] );
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        //$pdf->setHeader( true );
        //$pdf->setFooter( true );

        $i = 1;
        $pdf->AddPage();

        foreach ( $plan->template->sections as $section ) {

            $current_section = $section;
            if ( $current_section->isEmpty( $plan ) ) {
                continue;
            } else {
                if ( $i == 1 ) {
                    $pdf->startPageNums();
                }

                $pdf->SetFont( $options['section']['font'], $options['section']['style'], $options['section']['size'] );
                $pdf->SetDrawColor( 197, 14, 31 );
                $pdf->SetLineWidth( 0.5 );

                $section_text = strip_tags( $section->name );

                $pdf->Bookmark( $section_text, 0, 0, '', 'B', [ 0, 0, 0 ] );
                $pdf->Cell( 0, 8, $section_text, 'B', 1, 'L' );
                $pdf->Ln( 5 );
                $pdf->SetFillColor( 255, 255, 255 );

                foreach ( $section->questions->where('parent_question_id', null) as $question_id => $question ) {

                    if ( $question->input_type == 'headline' ) {
                        $font_weight = 'B';
                        $font_size = $options['question']['size'] + 2;
                    }
                    else {
                        $font_weight = $options['question']['style'];
                        $font_size = $options['question']['size'];
                    }
                    $pdf->SetFont( $options['question']['font'], $font_weight, $options['question']['size'] );

                    $answer_text = App\Answer::getAnswer( $plan, $question, 'pdf' );

                    if ( !is_null( $answer_text ) ) {
                        $pdf->Ln( 3 );
                        if( $question->output_text ) {
                            $question_text = iconv( 'UTF-8', 'windows-1252', strip_tags( $question->output_text ) );
                        } else {
                            $question_text = iconv( 'UTF-8', 'windows-1252', strip_tags( $question->text ) );
                        }
                        $pdf->MultiCell( 0, 5, $question_text, $options['border'], 1, $options['alignment'] );
                        $pdf->SetFont( $options['answer']['font'], $options['answer']['style'],
                            $options['answer']['size'] );

                        if ( $question->input_type != 'headline' ) {
                            $pdf->Ln( 1 );
                            $answer_text = strip_tags( $answer_text );
                            $hasUrl = preg_match( '@http://(?:www\.)?(\S+/)\S*(?:\s|$)@i', $answer_text, $links );

                            $pdf->Cell( $options['answer']['parent_margin'], 5, '', $options['border'], 0,
                                $options['alignment'] );
                            $pdf->MultiCell( 0, 5, $answer_text, $options['border'], 1, $options['alignment'] );
                        }
                    }

                    foreach ( $question->getChildren() as $question ) {

                        // TODO: REFACTOR recursively => include('partials.question.show', $question)
                        if ( $question->input_type == 'headline' ) {
                            $font_weight = 'B';
                        }
                        else {
                            $font_weight = $options['question']['style'];
                        }
                        $pdf->SetFont( $options['question']['font'], $font_weight, $options['question']['size'] );

                        $answer_text = App\Answer::getAnswer( $plan, $question, 'pdf' );

                        if ( !is_null( $answer_text ) ) {
                            $pdf->Ln( 3 );
                            if( $question->output_text )
                            {
                                $question_text = iconv( 'UTF-8', 'windows-1252', strip_tags( $question->output_text ) );
                            } else
                            {
                                $question_text = iconv( 'UTF-8', 'windows-1252', strip_tags( $question->text ) );
                            }
                            $pdf->MultiCell( 0, 5, $question_text, $options['border'], 1, $options['alignment'] );
                            $pdf->SetFont( $options['answer']['font'], $options['answer']['style'],
                                $options['answer']['size'] );

                            if ( $question->input_type != 'headline' ) {
                                $pdf->Ln( 1 );
                                $answer_text = strip_tags( $answer_text );
                                $pdf->Cell( $options['answer']['children_margin'], 5, '', $options['border'], 0,
                                    $options['alignment'] );
                                $pdf->MultiCell( 0, 5, $answer_text, $options['border'], 1, $options['alignment'] );
                            }
                        }

                        foreach ( $question->getChildren() as $question ) {

                            // TODO: REFACTOR recursively => include('partials.question.show', $question)
                            if ( $question->input_type == 'headline' ) {
                                $font_weight = 'B';
                            }
                            else {
                                $font_weight = $options['question']['style'];
                            }
                            $pdf->SetFont( $options['question']['font'], $font_weight, $options['question']['size'] );

                            $answer_text = App\Answer::getAnswer( $plan, $question, 'pdf' );

                            if ( !is_null( $answer_text ) ) {
                                $pdf->Ln( 3 );
                                if( $question->output_text )
                                {
                                    $question_text = iconv( 'UTF-8', 'windows-1252', strip_tags( $question->output_text ) );
                                } else
                                {
                                    $question_text = iconv( 'UTF-8', 'windows-1252', strip_tags( $question->text ) );
                                }
                                $pdf->MultiCell( 0, 5, $question_text, $options['border'], 1, $options['alignment'] );
                                $pdf->SetFont( $options['answer']['font'], $options['answer']['style'],
                                    $options['answer']['size'] );

                                if ( $question->input_type != 'headline' ) {
                                    $pdf->Ln( 1 );
                                    $answer_text = strip_tags( $answer_text );
                                    $pdf->Cell( $options['answer']['children_margin'], 5, '', $options['border'], 0,
                                        $options['alignment'] );
                                    $pdf->MultiCell( 0, 5, $answer_text, $options['border'], 1, $options['alignment'] );
                                }
                            }
                        }

                    }
                }
                $i++;
                $pdf->Ln( 5 );
            }
        }

        /* Cover Page with TOC */
        $pdf->addTOCPage();
        $pdf->SetFont( 'helvetica', 'B', 16 );
        $pdf->SetTextColor( 197, 14, 31 );
        $pdf->Cell( 0, 20, 'Data Management Plan', $options['border'], 1, 'L' );
        $pdf->SetTextColor( 0, 0, 0 );
        $pdf->SetFont( 'helvetica', 'BI', 12 );
        $pdf->MultiCell( 0, 5, $plan->getTitle(), $options['border'], 1, 'L' );
        $pdf->SetFont( 'helvetica', '', 12 );
        $pdf->Ln( 5 );
        $pdf->MultiCell( 0, 5, $plan->getInvestigators(), $options['border'], 1, 'L' );
        $pdf->Ln( 10 );
        $pdf->SetFont( 'helvetica', '', 10 );
        $pdf->MultiCell( 0, 5, 'TUB Project Number: ' . $plan->getProjectNumber(), $options['border'], 1, 'L' );
        //$pdf->MultiCell( 0, 5, 'Project Management Organization: ' . $plan->getLeadOrganization(), $options['border'], 1, 'L' );
        $pdf->Cell( 0, 5, 'DMP Version: ' . $plan->getVersion(), $options['border'], 1, 'L' );
        $pdf->Cell( 0, 5, 'Last modified: ' . $plan->updated_at->format( 'F d, Y' ), $options['border'], 1, 'L' );
        $pdf->Ln( 25 );
        $pdf->SetFont( $options['section']['font'], $options['section']['style'], $options['section']['size'] );
        $pdf->SetDrawColor( 197, 14, 31 );
        $pdf->SetLineWidth( 0.5 );
        $pdf->Cell( 0, 8, 'Table Of Contents', 'B', 1, 'L' );
        $pdf->Ln( 5 );
        $pdf->SetFillColor( 255, 255, 255 );
        $pdf->SetFont('helvetica', '', 12);
        $pdf->addTOC(1, 'helvetica', '.', 'Title Page', '', array(197, 14, 31));
        $pdf->endTOCPage();

        $output_mode = 'S';
        if ( $download == true ) {
            $output_mode = 'I';
        }

        return $pdf->Output( 'DMP for TUB Project ' . $plan->project_number . '-' . $plan->updated_at->format( 'Ymd' ),
            $output_mode );
    }

    public static function getFPDF( $plan, $matrix, $download ) {
        $options = [
            'page_orientation' => 'P',
            'page_unit'        => 'mm',
            'page_format'      => 'A4',
            'border'           => 0,
            'alignment'        => 'J',
            'page_margin'      => [ 'left' => 20, 'top' => 10 ],
            'toc'              => [ 'font' => 'Arial', 'style' => 'B', 'size' => 12 ],
            'section'          => [ 'font' => 'Arial', 'style' => 'B', 'size' => 14 ],
            'question'         => [
                'font'            => 'Arial',
                'style'           => 'B',
                'size'            => 10,
                'parent_margin'   => 0,
                'children_margin' => 0
            ],
            'answer'           => [
                'font'            => 'Arial',
                'style'           => '',
                'size'            => 10,
                'parent_margin'   => 4,
                'children_margin' => 4
            ]
        ];

        $metadata = [
            'title'   => 'Data Management Plan for Project ' . $plan->project_number . ' / Version ' . $plan->version,
            'author'  => Auth::user()->real_name,
            'creator' => 'TUB-DMP'
        ];

        $pdf = new PDF( $options['page_orientation'], $options['page_unit'], $options['page_format'] );

        $pdf->AddFont( 'Arial', '', 'arial.php' );
        $pdf->AddFont( 'Arial', 'B', 'arialbd.php' );
        $pdf->AddFont( 'Arial', 'I', 'ariali.php' );
        $pdf->AddFont( 'Arial', 'BI', 'arialbi.php' );

        $pdf->SetTitle( $metadata['title'] );
        $pdf->SetAuthor( $metadata['author'] );
        $pdf->SetAuthor( $metadata['creator'] );
        $pdf->SetMargins( $options['page_margin']['left'], $options['page_margin']['top'] );

        /* Cover Page */
        //$pdf->setHeader( false );
        //$pdf->setFooter( false );
        $pdf->AddPage();
        $pdf->SetFont( 'Arial', 'B', 16 );
        $pdf->SetTextColor( 197, 14, 31 );
        $pdf->Image( public_path() . '/images/logo-dmp-small.png', 85, 25 );
        $pdf->Ln( 25 );
        $pdf->Cell( 0, 20, 'Data Management Plan', $options['border'], 1, 'C' );
        $pdf->SetTextColor( 0, 0, 0 );
        $pdf->SetFont( 'Arial', 'B', 12 );
        $pdf->Cell( 0, 10, 'Project ' . $plan['project_number'], $options['border'], 1, 'C' );
        $pdf->SetFont( 'Arial', 'B', 10 );
        $pdf->Cell( 0, 10, 'DMP Version:  ' . $plan['version'], $options['border'], 1, 'C' );
        $pdf->Cell( 0, 10, 'Date: ' . $plan->updated_at->format( 'd/m/Y' ), $options['border'], 1, 'C' );

        //$pdf->setHeader( true );
        //$pdf->setFooter( true );

        $i = 1;
        $pdf->AddPage();
        foreach ( $matrix as $section ) {
            if( $section->isEmpty( $plan ) )
            {
                $pdf->Cell( 0, 8, 'Is Empty', 'B', 1, 'L' );
            } else {
                $pdf->Cell( 0, 8, 'Non Empty', 'B', 1, 'L' );
            }
            if ( $i == 1 ) {
                $pdf->startPageNums();
            }
            $pdf->SetFont( $options['section']['font'], $options['section']['style'], $options['section']['size'] );
            $pdf->SetDrawColor( 197, 14, 31 );
            $pdf->SetLineWidth( 1 );
            $section_text = iconv( 'UTF-8', 'windows-1252', strip_tags( $section['name'] ) );
            $pdf->TOC_Entry( $section_text, 0 );
            $pdf->Cell( 0, 8, $section_text, 'B', 1, 'L' );
            $pdf->Ln( 5 );
            $pdf->SetFillColor( 255, 255, 255 );

            foreach ( $section['questions'] as $question_id => $question ) {
                if ( $question['input_type'] == 'headline' ) {
                    $font_weight = 'B';
                    $font_size = $options['question']['size'] + 2;
                }
                else {
                    $font_weight = $options['question']['style'];
                    $font_size = $options['question']['size'];
                }
                $pdf->SetFont( $options['question']['font'], $font_weight, $options['question']['size'] );

                $answer_text = App\QuestionAnswerRelation::getAnswer( $plan, $question, 'text' );
                if ( !is_null( $answer_text ) ) {
                    $pdf->Ln( 3 );
                    $question_text = iconv( 'UTF-8', 'windows-1252', strip_tags( $question['text'] ) );
                    $pdf->MultiCell( 0, 5, $question_text, $options['border'], 1, $options['alignment'] );
                    $pdf->SetFont( $options['answer']['font'], $options['answer']['style'], $options['answer']['size'] );

                    if ( $question['input_type'] != 'headline' ) {
                        $pdf->Ln( 1 );
                        $answer_text = iconv( 'UTF-8', 'windows-1252', strip_tags( $answer_text ) );
                        $hasUrl = preg_match( '@http://(?:www\.)?(\S+/)\S*(?:\s|$)@i', $answer_text, $links );

                        //Log::info($hasUrl); // 'Message text.' appears in Clockwork log tab
                        //Log::info($links); // 'Message text.' appears in Clockwork log tab

                        $pdf->Cell( $options['answer']['parent_margin'], 5, '', $options['border'], 0,
                            $options['alignment'] );
                        $pdf->MultiCell( 0, 5, $answer_text, $options['border'], 1, $options['alignment'] );
                    }
                }

                foreach ( $question['children'] as $question ) {
                    // TODO: REFACTOR recursively => include('partials.question.show', $question)
                    if ( $question['input_type'] == 'headline' ) {
                        $font_weight = 'B';
                    }
                    else {
                        $font_weight = $options['question']['style'];
                    }
                    $pdf->SetFont( $options['question']['font'], $font_weight, $options['question']['size'] );

                    $answer_text = App\QuestionAnswerRelation::getAnswer( $plan, $question, 'text' );
                    if ( !is_null( $answer_text ) ) {
                        $pdf->Ln( 3 );
                        $question_text = iconv( 'UTF-8', 'windows-1252', strip_tags( $question['text'] ) );
                        $pdf->MultiCell( 0, 5, $question_text, $options['border'], 1, $options['alignment'] );
                        $pdf->SetFont( $options['answer']['font'], $options['answer']['style'],
                        $options['answer']['size'] );

                    if ( $question['input_type'] != 'headline' ) {
                            $pdf->Ln( 1 );
                            $answer_text = iconv( 'UTF-8', 'windows-1252', strip_tags( $answer_text ) );
                            $pdf->Cell( $options['answer']['children_margin'], 5, '', $options['border'], 0,
                                $options['alignment'] );
                            $pdf->MultiCell( 0, 5, $answer_text, $options['border'], 1, $options['alignment'] );
                        }
                    }
                }
            }
            $i++;
            $pdf->Ln( 5 );
        }
        $pdf->stopPageNums();
        $pdf->insertTOC( 2 );

        if ( $download == true ) {
            $output_mode = 'I';
        }
        else {
            $output_mode = 'S';
        }

        return $pdf->Output( 'DMP for Project ' . $plan->project_number . '-' . $plan->updated_at->format( 'Ymd' ),
            $output_mode );
    }

}