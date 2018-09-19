<?php

namespace LucLeroy\Strings;

interface BinaryStringInterface extends StringInterface
{
    /**
     * 
     * @param string $encoding
     * @return UnicodeStringInterface
     */
    public function toUnicode($encoding = 'UTF-8');
}
