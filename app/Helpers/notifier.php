<?php

use Xuma\Amaran\Facades\Amaran as Notify;


class Notifier extends Notify
{
    public static function success( $message ) {
        return Notify::content( [
            'message' => $message,
            'bgcolor' => '#449d44',
            'color'   => '#fff'
        ] )->theme( 'colorful' )->position( 'top right' )->inEffect( 'slideTop' )->outEffect( 'slideTop' );
    }


    public static function error( $message ) {
        return Notify::content( [
            'message' => $message,
            'bgcolor' => 'red',
            'color'   => '#fff'
        ] )->theme( 'colorful' )->position( 'top right' )->inEffect( 'slideTop' )->outEffect( 'slideTop' );
    }
}