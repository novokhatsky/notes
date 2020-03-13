<?php

namespace advor\module;

Trait Convert
{
    private $DICT = [
        '<br>'      => '?br?',
        '<b>'       => '?b?',
        '</b>'      => '?/b?',
        '<i>'       => '?i?',
        '</i>'      => '?/i?',
        '<code>'    => '?code?',
        '</code>'   => '?/code?',
    ];


    public function html2text($text)
    {
        foreach ($this->DICT as $key => $value) {
            $text = str_replace($key, $value, $text);
        }

        return $text;
    }


    public function text2html($text)
    {
        foreach ($this->DICT as $key => $value) {
            $text = str_replace($value, $key, $text);
        }

        return $text;
    }
}

