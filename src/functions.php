<?php

namespace LucLeroy\Strings;

/**
 * 
 * @param type $string
 * @return CaseSensitiveBinaryString
 */
function s($string)
{
    return new CaseSensitiveBinaryString($string);
}

/**
 * 
 * @param type $string
 * @return CaseSensitiveUnicodeString
 */
function u($string)
{
    return new CaseSensitiveUnicodeString($string);
}
