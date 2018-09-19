<?php

namespace LucLeroy\Strings\SubstringList;

use LucLeroy\Strings\CaseSensitiveInterface;


/**
 * @method CaseSensitiveBinaryString implode(string $separator)
 */
class CaseSensitiveBinarySubstringList extends AbstractBinarySubstringList implements CaseSensitiveInterface
{
    
    /**
     * 
     * @return CaseInsensitiveBinarySubstringList
     */
    public function toCaseInsensitive()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

}
