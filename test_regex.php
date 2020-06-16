<?php

$string = '240p audio video';

function checkContainsAudioAndVideoFormat($string) : ?string
{
    foreach (['audio', 'video'] as $elem) {
        if (strpos($string, $elem) === false) {
            return null;
        }

        preg_match('/([0-9]{2,4})p/', $string, $match);

        return $match[1] ?? null;
    }
}

var_dump(checkContainsAudioAndVideoFormat($string));

