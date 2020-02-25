<?php

namespace advor\models;

Class Convert
{
    const DICT = [
        '<br>'      => '?br?',
        '<b>'       => '?b?',
        '</b>'      => '?/b?',
        '<i>'       => '?i?',
        '</i>'      => '?/i?',
        '<code>'    => '?code?',
        '</code>'   => '?/code?',
    ];


    static function html2text($text)
    {
        foreach (self::DICT as $key => $value) {
            $text = str_replace($key, $value, $text);
        }
        $text = htmlspecialchars($text);
        return $text;
    }


    static function text2html($text)
    {
        foreach (self::DICT as $key => $value) {
            $text = str_replace($value, $key, $text);
        }

        return $text;
    }
}

