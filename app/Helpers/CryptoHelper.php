<?php

function encryptURL($str)
{
    $revert = array('%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')');
    $encrypted = strtr(rawurlencode($str), $revert);

    return $encrypted;
}

function decryptURL($str)
{
    $revert = array('%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')');
    $decrypted = strtr(rawurldecode($str), $revert);

    return $decrypted;
}
