<?php

namespace LucLeroy\Strings\SubstringList;


class AbstractBinarySubstringList extends AbstractSubstringList implements \LucLeroy\Strings\BinaryStringInterface
{
    
    /**
     * 
     * {@inheritdoc}
     */
    public function toUnicode($encoding = 'UTF-8')
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

}
