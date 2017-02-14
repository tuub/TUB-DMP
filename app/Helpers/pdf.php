<?php


//use FPDF;

class PDF extends TCPDF
{
    var $_toc             = [ ];
    var $_numbering       = false;
    var $_numberingFooter = false;
    var $_numPageNum      = 1;
    var $_hasHeader       = true;
    var $_hasFooter       = true;


    /*
    function setHeader( $switch = true ) {
        $this->_hasHeader = $switch;
    }


    function setFooter( $switch = true ) {
        $this->_hasFooter = $switch;
    }
    */


    function startPageNums() {
        $this->_numbering = true;
        $this->_numberingFooter = true;
    }


    function TOC_Entry( $txt, $level = 0 ) {
        $this->_toc[] = [ 't' => $txt, 'l' => $level, 'p' => $this->numPageNo() ];
    }


    function numPageNo() {
        return $this->_numPageNum;
    }


    function insertTOC(
        $location = 1,
        $labelSize = 14,
        $entrySize = 10,
        $tocfont = 'Arial',
        $label = 'Table of Contents'
    ) {
        //make toc at end
        $this->stopPageNums();
        $this->AddPage();
        $tocstart = $this->page;

        $this->SetFont( $tocfont, 'B', $labelSize );
        $this->SetDrawColor( 197, 14, 31 );
        $this->SetLineWidth( 1 );
        $this->Cell( 0, 8, $label, 'B', 1, 'L' );
        $this->Ln( 8 );
        $this->SetFillColor( 255, 255, 255 );

        foreach ( $this->_toc as $t ) {

            //Offset
            $level = $t['l'];
            if ( $level > 0 ) {
                $this->Cell( $level * 8 );
            }
            $weight = '';
            if ( $level == 0 ) {
                $weight = '';
            }
            $str = $t['t'];
            $this->SetFont( $tocfont, $weight, $entrySize );
            $strsize = $this->GetStringWidth( $str );
            $this->Cell( $strsize + 2, $this->FontSize + 2, $str );

            //Filling dots
            $this->SetFont( $tocfont, '', $entrySize );
            $PageCellSize = $this->GetStringWidth( $t['p'] ) + 2;
            $w = $this->w - $this->lMargin - $this->rMargin - $PageCellSize - ( $level * 8 ) - ( $strsize + 2 );
            $nb = $w / $this->GetStringWidth( '.' );
            $dots = str_repeat( '.', $nb );
            $this->Cell( $w, $this->FontSize + 2, $dots, 0, 0, 'R' );

            //Page number
            $this->Cell( $PageCellSize, $this->FontSize + 2, $t['p'], 0, 1, 'R' );
        }

        //Grab it and move to selected location
        $n = $this->page;
        $n_toc = $n - $tocstart + 1;
        $last = [ ];

        //store toc pages
        for ( $i = $tocstart; $i <= $n; $i++ ) {
            $last[] = $this->pages[ $i ];
        }

        //move pages
        for ( $i = $tocstart - 1; $i >= $location - 1; $i-- ) {
            $this->pages[ $i + $n_toc ] = $this->pages[ $i ];
        }

        //Put toc pages at insert point
        for ( $i = 0; $i < $n_toc; $i++ ) {
            $this->pages[ $location + $i ] = $last[ $i ];
        }
    }


    function stopPageNums() {
        $this->_numbering = false;
    }


    function AddPage( $orientation = '', $format = '', $keepmargins = false, $tocpage = false ) {
        parent::AddPage( $orientation, $format, $keepmargins, $tocpage );
        if ( $this->_numbering ) {
            $this->_numPageNum++;
        }
    }

    //Page header
    public function Header() {
        $this->SetFont( 'helvetica', 'I', 8 );
    }

    // Page footer
    public function Footer() {
        $this->SetFont( 'helvetica', 'I', 8 );
    }


    /*
    function Footer() {
        if ( !$this->_numberingFooter ) {
            return;
        }
        if ( $this->_hasFooter === true ) {
            $this->SetY( -15 );
            //Select Arial italic 8
            $this->SetFont( 'Arial', 'I', 8 );
            $this->Cell( 0, 7, $this->numPageNo(), 0, 0, 'C' );
        }
        if ( !$this->_numbering ) {
            $this->_numberingFooter = false;
        }
    }
    */

    /*
    public function Header() {
        //Log::info($this->_hasHeader);
        if ( $this->_hasHeader === true ) {
            $this->SetFont( 'Arial', 'I', 8 );
            $this->Image( public_path() . '/images/logo-tu-small.png', 20, 11, 8, 0, 'png' );
            $this->Cell( 10, 10, '' );
            $this->Cell( 30, 10, $this->metadata['Title'], 0, 1, 'L' );
        }
    }
    */
}