<?php

namespace Cli;

class StringProcessor
{
    public string $inputString;

    public function __construct(string $inputString)
    {
        $this->inputString = $inputString;
    }

    public function revertCharacters(): string
    {
        $resp = '';
        if ($this->inputString) {
            $arr = explode(' ', $this->inputString);

            foreach ($arr as $key => $elem) {
                $arr[$key] = $this->mb_strev($elem);
            }

            return implode(' ', $arr);
        }
        return $resp;
    }

    private function revertWord($word)
    {
        $arr = str_split($this->mb_strev($word));

        $arrRev = str_split(mb_strtolower(preg_replace('/\pP/iu', '', $word)));
        $num = count($arrRev) - 1;

        for ($i = 0; $i < count($arr); $i++) {
            if (ctype_punct($arr[$i])) continue;
            if (ctype_upper($arr[$i])) {
                $arr[$i] = strtoupper($arrRev[$num]);
            } else {
                $arr[$i] = $arrRev[$num];
            }

            $num--;
        }

        return implode($arr);
    }

    private function mb_strev($string, $encoding = null)
    {
        if ($encoding === null) {
            $encoding = mb_detect_encoding($string);
        }

        $length = mb_strlen($string, $encoding);
        $reversed = '';
        while ($length-- > 0) {
            $reversed .= mb_substr($string, $length, 1, $encoding);
        }

        $reversedLower = array_reverse(mb_str_split(mb_strtolower(preg_replace('/\pP/iu', '', $reversed))));
        $reversed = mb_str_split($reversed);
        $num = count($reversedLower) - 1;

        for ($i = 0; $i < count($reversed); $i++) {
            if (ctype_punct($reversed[$i])) {
                continue;
            }
            if (mb_strtolower($reversed[$i]) !== $reversed[$i]) {
                $reversed[$i] = strtoupper($reversedLower[$num]);
                $reversed[0] = mb_strtoupper($reversed[0]);
            } else {
                $arr[$i] = $reversedLower[$num];
            }
            $num--;
        }
        return implode($reversed);
    }
}
