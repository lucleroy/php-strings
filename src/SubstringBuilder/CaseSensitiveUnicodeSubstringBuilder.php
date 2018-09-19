<?php

namespace LucLeroy\Strings\SubstringBuilder;

use LucLeroy\Strings\CaseSensitiveUnicodeString;
use LucLeroy\Strings\StringInterface;
use LucLeroy\Strings\UnicodeStringInterface;
use function mb_strlen;
use function mb_strpos;
use function mb_strrpos;
use function mb_substr;

class CaseSensitiveUnicodeSubstringBuilder extends AbstractUnicodeSubstringBuilder
{

    /**
     * 
     * @return CaseSensitiveUnicodeSubstringBuilder
     */
    protected function makeSubstringBuilder($from, $to)
    {
        return new CaseSensitiveUnicodeSubstringBuilder($this->parent, $this->offset, $from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveUnicodeString
     */
    public function build()
    {
        return new CaseSensitiveUnicodeString($this->toString(), $this->parent->getEncoding(), $this);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function patch($patch)
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

        return new CaseSensitiveUnicodeString($patched, $this->parent->getEncoding(), $this->parent->getParent());
    }

    protected function strpos($substring, $offset = 0)
    {
        $pos = mb_strpos($this->str, $substring, $this->offset + $offset, CaseSensitiveUnicodeString::ENCODING);
        if ($pos !== false) {
            $pos -= $this->offset;
        }
        return $pos;
    }

    protected function strrpos($substring, $offset = 0)
    {
        $pos = mb_strrpos($this->str, $substring, $this->offset + $offset, CaseSensitiveUnicodeString::ENCODING);
        if ($pos !== false) {
            $pos -= $this->offset;
        }
        return $pos;
    }

    protected function strlen($string)
    {
        return mb_strlen($string, UnicodeStringInterface::ENCODING);
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
        return parent::regexForBetween($open, $close, $match)->getUtf8OptimizedRegex();
    }

}
