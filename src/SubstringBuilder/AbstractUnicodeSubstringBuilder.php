<?php

namespace LucLeroy\Strings\SubstringBuilder;

use LucLeroy\Strings\UnicodeStringInterface;

abstract class AbstractUnicodeSubstringBuilder extends AbstractSubstringBuilder
{

    /**
     * 
     * {@inheritdoc}
     * 
     * @return string
     */
    public function toString(): string
    {
        list($from, $to) = $this->realSelection();
        $length = $to - $from;

        if ($length > 0) {
            $result = mb_substr($this->str, $this->from + $this->offset, $length,
                UnicodeStringInterface::ENCODING);
        } else {
            $result = '';
        }

        return $result;
    }

    protected function encodeString($string)
    {
        if (is_string($string)) {
            $encoding = $this->parent->getEncoding();
            return $encoding === UnicodeStringInterface::ENCODING
                ? $string
                : mb_convert_encoding($string, UnicodeStringInterface::ENCODING, $encoding);
        } elseif ($string instanceof UnicodeStringInterface) {
            $stringEncoding = $string->getEncoding();
            return $stringEncoding === UnicodeStringInterface::ENCODING
                ? $string
                : mb_convert_encoding($string, UnicodeStringInterface::ENCODING, $stringEncoding);
        } else {
            return (string) $string;
        }
    }

    protected function strlen($string)
    {
        return mb_strlen($string, UnicodeStringInterface::ENCODING);
    }
    
    protected function byteOffset() {
        return strlen(mb_substr($this->str, 0, $this->offset));
    }
    
    protected function byteToCharIndex($index)
    {
        return strlen(utf8_decode(substr($this->str, 0, $index)));
    }

}
