<?php

namespace MisterMarlu;

/**
 * Class Build
 *
 * @package MisterMarlu
 * @author Luca Braun <mistermarlu-tv@web.de>
 */
class Build {

    /**
     * @var array
     */
    private static $answer;

    /**
     */
    public static function build() {
        self::insertJS();
        self::isMisterMarlu();
    }

    /**
     */
    private static function isMisterMarlu() {
        if ( !isset( $_GET['MisterMarlu'] ) ) return;

        $answerText = self::getAnswerText();

        if ( empty( $answerText ) ) return;

        echo nl2br( $answerText );
        die();
    }

    /**
     *
     */
    private static function insertJS() {
        $filePath = static::asset( '/js/mistermarlu.js' );

        if ( !file_exists( $filePath ) ) return;

        $script = '<script type="text/javascript">';
        $script .= str_replace( '%answer%', static::getAnswerText( true ), file_get_contents( $filePath ) );
        $script .= '</script>';

        echo $script;
    }

    /**
     * @param bool $useRN
     * @return string
     */
    private static function getAnswerText( $useRN = false ): string {
        $filePath = static::asset( '/include/answer.php' );

        if ( !file_exists( $filePath ) ) return '';

        if ( empty( self::$answer ) ) self::$answer = require_once $filePath;
        $answerText = '';

        for ( $i = 0; $i < count( self::$answer ); $i += 1 ) {
            $answerText .= self::$answer[$i];
            if ( $i + 1 < count( self::$answer ) && $useRN ) $answerText .= '\r\n';
            if ( $i + 1 < count( self::$answer ) && !$useRN ) $answerText .= '<br />';
        }

        return $answerText;
    }

    /**
     * @param string $path
     * @return string
     */
    private static function asset( $path = '' ): string {
        return dirname( __FILE__ ) . '/../asset' . $path;
    }
}