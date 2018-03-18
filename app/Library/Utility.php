<?php
/**
 * Utility Class
 */

declare(strict_types=1);

namespace App\Library;

use AppHelper;

/**
 * Class Utility
 *
 * @package App\Library
 */
class Utility
{
    /**
     * Prepare dropdown-box ready values for given model
     *
     * Usage:
     * \AppHelper::varDump( Utility::getValuesForDropdown('MetadataRegistry', ['title', 'id']) );
     * \AppHelper::varDump( Utility::getValuesForDropdown('ContentType', ['title', 'id'], ['title', 'asc']) );
     *
     * @uses AppHelper::camelCaseToWord()
     * @param string $model
     * @param array $values
     * @param array $order
     * @return \Illuminate\Support\Collection
     */
    public static function getValuesForDropdown(string $model, array $values = null, array $order = null)
    {
        $options = collect([null => 'Disabled - bad configuration']);
        $modelClass = 'App\\' . class_basename($model);
        $modelName = AppHelper::camelCaseToWord($model);

        $value   = $values[0] ?? 'id';
        $display = $values[1] ?? 'id';
        $sortBy  = $order[0] ?? 'id';
        $sortDir = $order[1] ?? 'asc';

        if (class_exists($modelClass))
        {
            $model_obj = app()->make($modelClass);
            $options = $model_obj
                ->orderBy($sortBy, $sortDir)
                ->get()
                ->pluck($value, $display)
                ->prepend('Select a ' . $modelName,'');
        }

        return $options;
    }
}