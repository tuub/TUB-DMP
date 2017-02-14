<?php
namespace App\Library;

interface OutputInterface
{
    function render();

    // TO DO: OutputFilters => $output = 'form'
    // TO DO: maybe ... $convert_links = false
}