<?php

function getHash($size = 16)
{
    $str = 'abcdefghijklmnopqrstuvwxyz1234567890';
    $hash = '';
    for ($i = 0; $i < $size; $i++) {
        $hash .= $str[rand(0, 35)];
    }
    return $hash;
}


?>