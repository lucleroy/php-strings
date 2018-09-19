<?php

namespace LucLeroy\Strings\SubstringBuilder;

use LucLeroy\Strings\CaseInsensitiveBinaryString;

class CaseInsensitiveBinarySubstringBuilder extends AbstractBinarySubstringBuilder
{

    /**
     * 
     * @return CaseInsensitiveBinarySubstringBuilder
     */
    protected function makeSubstringBuilder($from, $to)
    {
        return new CaseInsensitiveBinarySubstringBuilder($this->parent, $this->offset, $from, $to);
    }

    protected function strpos($substring, $offset = 0)
    {
        $pos = stripos($this->str, $substring, $this->offset + $offset);
        if ($pos !== false) {
            $pos -= $this->offset;
        }
        return $pos;
    }

    protected function strrpos($substring, $offset = 0)
    {
        $pos = strripos($this->str, $substring, $this->offset + $offset);
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
     * @return CaseInsensitiveBinaryString
     */
    public function build()
    {
        return new CaseInsensitiveBinaryString($this->toString(), $this);
    }
    
    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveBinaryString
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

        return new CaseInsensitiveBinaryString($patched, $this->parent->getParent());
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
        return parent::regexForBetween($open, $close, $match)->getOptimizedRegex() . 'i';
    }

}
