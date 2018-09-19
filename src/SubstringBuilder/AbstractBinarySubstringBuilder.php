<?php

namespace LucLeroy\Strings\SubstringBuilder;

abstract class AbstractBinarySubstringBuilder extends AbstractSubstringBuilder
{

    /**
     * 
     * {@inheritdoc}
     * 
     * @return string
     */
    public function toString()
    {
        list($from, $to) = $this->realSelection();
        $length = $to - $from;

        if ($length > 0) {
            $result = substr($this->str, $from + $this->offset, $length);
        } else {
            $result = '';
        }

        return $result;
    }

    protected function strlen($string)
    {
        return strlen($string);
    }
    
    protected function byteOffset() {
        return $this->offset;
    }
    
    protected function byteToCharIndex($index) {
        return $index;
    }
}
