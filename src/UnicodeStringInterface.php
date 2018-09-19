<?php

namespace LucLeroy\Strings;

interface UnicodeStringInterface extends StringInterface
{

    const ENCODING = 'UTF-8';
    
    /**
     * @return string
     */
    public function getEncoding();

    /**
     * 
     * @param string $encoding
     * @return static
     */
    public function toEncoding($encoding);

    /**
     * @return BinaryStringInterface
     */
    public function toBinary();

    /**
     * Convert to ASCII.
     * 
     * @return static
     */
    public function ascii();
}
