<?php

namespace App\Library;

use Storage;

use Intervention\Image\ImageManagerStatic as Image;

class ImageFile
{
    protected $file;
    protected $image;
    protected $x;
    protected $y;

    public function __construct($file) {
        $this->file = $file;
        Image::configure(array('driver' => 'imagick'));
        $this->image = Image::make($this->file);
    }

    public function getWidth() {
        return getimagesize($this->file)[0];
    }

    public function getHeight() {
        return getimagesize($this->file)[1];
    }

    public function getFullPath() {
        return $this->getFileDirectory() . '/' . $this->getFileName() . '.' . $this->getExtension();
    }

    public function getFileDirectory() {
        return pathinfo($this->file, PATHINFO_DIRNAME);
    }

    public function getFileName() {
        return pathinfo($this->file, PATHINFO_FILENAME);
    }

    public function getExtension() {
        return pathinfo($this->file, PATHINFO_EXTENSION);
    }

    public function resizeTo($image_path, $x = null, $y = null) {

        //http://image.intervention.io/getting_started/installation
        //http://image.intervention.io/

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


    public function renderAs($format) {
        return $this->image->response($format);
    }


    // FIXME:
    // options should contain storage (public_logo) + directory (template->id) + filename (original) + extension (png)
    // Result images/logo/a3543-34634-324324-3244/original.png
    public static function createVersions($file, $options) {

        if (Storage::disk('public_logo')->makeDirectory($options['identifier'])) {
            $file_name = 'original.' . $options['extension'];
            $file_path = Storage::disk('public_logo')->path($options['identifier']);
            $file_extension = $options['extension'];
            $versions = config('upload.template_logo.formats');

            $file->storePubliclyAs($options['identifier'], $file_name, 'public_logo');

            foreach ($versions as $version => $dimension) {
                $new_file = new ImageFile($file_path . '/' . $file_name);
                $image_path = $file_path . '/' . $version . '.' . $new_file->image->extension;
                $new_file->resizeTo($image_path, $dimension['x'], $dimension['y']);
            }
            return true;
        }

        return false;
    }


    public static function deleteVersions($identifier, $options) {

        if ($options['disk']) {
            $path = Storage::disk($options['disk'])->getAdapter()->getPathPrefix() . $identifier;
        } else {
            $path = 'local';
        }

        if (Storage::exists($path)) {
            if (Storage::deleteDirectory($path)) {
                return true;
            }
        }

        return false;
    }


    public static function getVersions() {
        $versions = config('upload.template_logo.formats');

        return $versions;
    }


    public static function getVersion($path, $version) {

        $versions = self::getVersions();

        if (array_key_exists($version, $versions)) {
            $files = Storage::files($path);
            foreach ($files as $file) {
                if (str_contains($file, $version)) {
                    return $file;
                }
            }
        }
    }
}
