<?php
declare(strict_types=0);

namespace App\Library;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


/**
 * Class ImageFile
 *
 * @package App\Library
 */
class ImageFile
{
    protected $file;
    protected $image;
    protected $x;
    protected $y;


    /**
     * ImageFile constructor.
     *
     * @param $file
     * @return void
     */
    public function __construct($file) {
        $this->file = $file;
        Image::configure(['driver' => 'imagick']);
        $this->image = Image::make($this->file);
    }


    /**
     * @return int|bool
     */
    public function getWidth() {
        return getimagesize($this->file)[0];
    }


    /**
     * @return int|bool
     */
    public function getHeight() {
        return getimagesize($this->file)[1];
    }


    /**
     * @return string
     */
    public function getFullPath() {
        return $this->getFileDirectory() . '/' . $this->getFileName() . '.' . $this->getExtension();
    }


    /**
     * @return string
     */
    public function getFileDirectory() {
        return pathinfo($this->file, PATHINFO_DIRNAME);
    }


    /**
     * @return string
     */
    public function getFileName() {
        return pathinfo($this->file, PATHINFO_FILENAME);
    }


    /**
     * @return string
     */
    public function getExtension() {
        return pathinfo($this->file, PATHINFO_EXTENSION);
    }


    /**
     * Resize an image from given image path.
     *
     * See http://image.intervention.io/ for details on the used library.
     *
     * @param string $image_path
     * @param $x
     * @param $y
     *
     * @return \Intervention\Image\Image
     */
    public function resizeTo($image_path, $x = null, $y = null) {

        $file = clone $this->image;

        if ($x === null && $y === null) {
            return $file;
        }

        if ($x !== null && $y === null) {
            $file->resize($x, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        } elseif ($x === null && $y !== null) {
            $file->resize(null, $y, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        } else {
            $file->resize($x, $y);
        }

        $file->encode($this->image->extension, 100);
        $file->save($image_path, 100);

        return $file;
    }


    /**
     * Creates different versions of a given file handle from upload
     *
     * Versions are defined in config/upload.php (template_logo.formats).
     * Options Example:
     *
     *   'disk' => 'public_logo',
     *   'identifier' => '12345678',
     *   'extension' => 'png'
     *
     * Example result: images/logo/12345678/original.png
     *
     * @uses \App\Library\ImageFile::resizeTo()
     * @param \Illuminate\Http\UploadedFile $file
     * @param array $options
     * @return bool
     */
    public static function createVersions($file, $options) {

        if (Storage::disk($options['disk'])->makeDirectory($options['identifier'])) {
            $file_name = 'original.' . $options['extension'];
            $file_path = Storage::disk($options['disk'])->path($options['identifier']);
            $versions = self::getVersions();

            $file->storePubliclyAs($options['identifier'], $file_name, $options['disk']);

            foreach ($versions as $version => $dimension) {
                $new_file = new ImageFile($file_path . '/' . $file_name);
                $image_path = $file_path . '/' . $version . '.' . $new_file->image->extension;
                $new_file->resizeTo($image_path, $dimension['x'], $dimension['y']);
            }
            return true;
        }

        return false;
    }


    /**
     * What does it do
     *
     * Description
     *
     * @param string $identifier
     * @param array $options
     * @return bool
     */
    public static function deleteVersions($identifier, $options) {

        if ($options['disk']) {
            $path = Storage::disk($options['disk'])->getAdapter()->getPathPrefix() . $identifier;
        } else {
            $path = 'local';
        }

        return Storage::exists($path) && Storage::deleteDirectory($path);
    }


    /**
     * Get config array from config/upload.php
     *
     * @return array
     */
    public static function getVersions() {
        /* @todo Generalize here */
        return config('upload.template_logo.formats');
    }


    /**
     * Returns path for given path and given version.
     *
     * @todo: Generalize the versions, add disk param
     *
     * @param $path
     * @param $version
     * @return string
     */
    public static function getVersion($path, $version) {

        $versions = self::getVersions();
        $file_path = '';

        if (array_key_exists($version, $versions)) {

            /* @var $files array */
            $files = Storage::files($path);

            foreach ($files as $file) {
                if (str_contains($file, $version)) {
                    $file_path = $file;
                }
            }
        }

        return $file_path;
    }


    /**
     * Test method for rendering images live
     *
     * @param string $format
     * @return \Intervention\Image\Image
     */
    public function renderAs($format) {
        return $this->image->response($format);
    }
}
