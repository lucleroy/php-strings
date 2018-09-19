<?php

namespace LucLeroy\Strings\SubstringList;

use LucLeroy\Strings\CaseInsensitiveInterface;

/**
 * @method CaseInsensitiveBinaryString implode(string $separator)
 */
class CaseInsensitiveBinarySubstringList extends AbstractBinarySubstringList implements CaseInsensitiveInterface
{
    
    /**
     * 
     * @return CaseSensitiveBinarySubstringList
     */
    public function toCaseSensitive()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

}
