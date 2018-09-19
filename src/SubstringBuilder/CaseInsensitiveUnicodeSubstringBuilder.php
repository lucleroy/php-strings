<?php

namespace LucLeroy\Strings\SubstringBuilder;

use LucLeroy\Strings\CaseInsensitiveUnicodeString;
use LucLeroy\Strings\StringInterface;
use LucLeroy\Strings\UnicodeStringInterface;
use function mb_stripos;
use function mb_strripos;

class CaseInsensitiveUnicodeSubstringBuilder extends AbstractUnicodeSubstringBuilder
{

    /**
     * 
     * @return CaseInsensitiveUnicodeSubstringBuilder
     */
    protected function makeSubstringBuilder($from, $to)
    {
        return new CaseInsensitiveUnicodeSubstringBuilder($this->parent, $this->offset, $from, $to);
    }

    protected function strpos($substring, $offset = 0)
    {
        $pos = mb_stripos($this->str, $substring, $this->offset + $offset, UnicodeStringInterface::ENCODING);
        if ($pos !== false) {
            $pos -= $this->offset;
        }
        return $pos;
    }

    protected function strrpos($substring, $offset = 0)
    {
        $pos = mb_strripos($this->str, $substring, $this->offset + $offset, UnicodeStringInterface::ENCODING);
        if ($pos !== false) {
            $pos -= $this->offset;
        }
        return $pos;
    }

    protected function charsForComparison($string)
    {
        return $this->parent->replace($string)->lower()->chars();
    }
    
    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveUnicodeString
     */
    public function build()
    {
        return new CaseInsensitiveUnicodeString($this->toString(), $this->parent->getEncoding(), $this);
    }
    
    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveUnicodeString
     */
    public function patch($patch): StringInterface
    {
        $from = $this->from;
        $to = $this->to;
        $str = $this->str;

        if ($from <= $to) {
            $from += $this->offset;
            $to += $this->offset;
            $patched = mb_substr($str, 0, $from, UnicodeStringInterface::ENCODING)
                . $this->encodeString($patch)
                . mb_substr($str, $to, null, UnicodeStringInterface::ENCODING);
        } else {
            $patched = $str;
        }

        return new CaseInsensitiveUnicodeString($patched, $this->parent->getEncoding(), $this->parent->getParent());
    }
    
    /**
     * 
     * @param string $open
     * @param string $close
     * @param bool $match
     * @return string
     */
    protected function regexForBetween($open, $close, $match = false)
    {
        return parent::regexForBetween($open, $close, $match)->getUtf8OptimizedRegex() . 'i';
    }

}
