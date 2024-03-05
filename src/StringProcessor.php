<?php

namespace Cli;

/**
 * @property string $inputString;
 */
class StringProcessor
{
    public string $inputString;

    public function __construct(string $inputString)
    {
        $this->inputString = $inputString;
    }

    /**
     * Splits a string into an array of words.
     * Returns a string with the words expanded backwards.
     * @return string
     */
    public function revertCharacters(): string
    {
        $resp = '';
        if ($this->inputString) {
            $arr = explode(' ', $this->inputString);

            foreach ($arr as $key => $elem) {
                $arr[$key] = $this->revertWords($elem);
            }

            $resp = implode(' ', $arr);
        }
        return $resp;
    }

    /**
     * Splits the word into an array of characters,
     * with support for the Cyrillic alphabet.
     * Returns a string of reversed characters,
     * preserving the case of the first letter and the location of punctuation characters.
     * @return string
     */
    private function revertWords(string $string, string $encoding = null): string
    {
        $result = '';
        
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
        $punct = '';
        $firstUp = false;

        for ($i = 0; $i < count($reversed); $i++) {
            if (ctype_punct($reversed[$i])) {
                $punct = $reversed[$i];
                continue;
            }
            if (mb_strtolower($reversed[$i]) !== $reversed[$i]) {
                $firstUp = true;
                $result .= $reversedLower[$num];
            } else {
                $result .= $reversedLower[$num];
            }
            $num--;
        }

        if ($firstUp) {
            $result = mb_str_split($result);
            $result[0] = mb_strtoupper($result[0]);
        }
        if ($punct) {
            if (is_array($result)) {
                array_push($result, $punct);
            } else {
                $result .= $punct;
            }
        }

        if(is_array($result)) {
            $result = implode($result);
        }
        return $result;
    }
}
