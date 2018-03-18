<?php
declare(strict_types=1);

namespace App\Library;

/**
 * Interface OutputInterface
 *
 * @todo: Documentation
 *
 * @package App\Library
 */
interface OutputInterface
{
    /**
     * @todo: Documentation
     *
     * @return mixed
     *
     */
    function render();

    // TO DO: OutputFilters => $output = 'form'
    // TO DO: maybe ... $convert_links = false
}