<?php

namespace App\Library\Traits;
use Webpatser\Uuid\Uuid;

trait Uuids
{

    /**
    * Boot function from laravel.
    */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::generate()->string;
        });
    }
}