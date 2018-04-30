<?php
declare(strict_types=1);

namespace App\Helpers;

/**
 * Class AppHelper
 */
class AppHelper {

    /**
     * Pretty-Print for var_dump a given variable.
     *
     * @param mixed $var
     * @return void
     */
    public static function varDump($var)
    {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();

        $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dashed #888; padding: 10px; margin: 10px 0; text-align: left;">'.$output.'</pre>';

        echo $output;
    }


    /**
     * Tests if a given $value is an empty string.
     *
     * @param string $value
     * @return bool
     */
    public static function isEmpty($value)
    {
        return \is_string($value) && empty($value);
    }


    /**
     * Tests if a given $value is an empty array.
     *
     * @param array $array
     * @return bool
     */
    public static function isEmptyArray($array)
    {
        if (\is_array($array)) {
            foreach($array as $key => $value) {
                if (!empty($value)) {
                    return false;
                }
            }
        }

        return true;
    }


    /**
     * Tests if given $array contains given $keys.
     *
     * @param array $array
     * @param array $keys
     * @return bool
     */
    public static function hasKeys($array, $keys)
    {
        if (\is_array($array)) {
            foreach ($keys as $key) {
                if (array_key_exists($key, $array)) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Tests if given $array contains empty values.
     *
     * @param array $array
     * @return bool
     */
    public static function hasEmptyValues($array)
    {
        if (\is_array($array)) {
            foreach ($array as $key => $value) {
                if (empty($value)) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Converts camel-cased string (typically a class name) to spaced string.
     *
     * @param string $string
     * @return string
     */
    public static function camelCaseToWord(string $string)
    {
        $pattern = '/
              (?<=[a-z])
              (?=[A-Z])
            | (?<=[A-Z])
              (?=[A-Z][a-z])
            /x';

        return implode(' ', preg_split($pattern, $string));
    }


    public static function uriToPageTitle(array $path_info)
    {
        if ($path_info['path']) {
            $path = $path_info['path'];
            $path_array = explode('/', $path);
            $path_array = array_filter($path_array, function($value) { return $value !== ''; });
            $path_array = array_map(function($word) { return ucfirst($word); }, $path_array);
            return implode(' > ', $path_array);
        }
    }
}