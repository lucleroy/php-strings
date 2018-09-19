<?php

namespace LucLeroy\Strings\SubstringBuilder;

use LucLeroy\Strings\CaseSensitiveBinaryString;

class CaseSensitiveBinarySubstringBuilder extends AbstractBinarySubstringBuilder
{

    /**
     * 
     * @return CaseSensitiveBinarySubstringBuilder
     */
    protected function makeSubstringBuilder($from, $to)
    {
        return new CaseSensitiveBinarySubstringBuilder($this->parent, $this->offset, $from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveBinaryString
     */
    public function build()
    {
        return new CaseSensitiveBinaryString($this->toString(), $this);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveBinaryString
     */
    public function patch($patch)
    {
        $from = $this->from;
        $to = $this->to;
        $str = $this->str;

        if ($from <= $to) {
            $from = max(0, $from + $this->offset);
            $to = min($this->len, $to + $this->offset);
            $patched = substr_replace($str, (string) $patch, $from, $to - $from);
        } else {
            $patched = $str;
        }

        return new CaseSensitiveBinaryString($patched, $this->parent->getParent());
    }

    protected function strpos($substring, $offset = 0)
    {
        $pos = strpos($this->str, $substring, $this->offset + $offset);
        if ($pos !== false) {
            $pos -= $this->offset;
        }
        return $pos;
    }

    protected function strrpos($substring, $offset = 0)
    {
        $pos = strrpos($this->str, $substring, $this->offset + $offset);
        if ($pos !== false) {
            $pos -= $this->offset;
        }
        return $pos;
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
        return parent::regexForBetween($open, $close, $match)->getOptimizedRegex();
    }

}
