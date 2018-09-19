<?php

namespace LucLeroy\Strings\SubstringList;

use LucLeroy\Strings\CaseInsensitiveInterface;

/**
 * @method CaseInsensitiveUnicodeString implode(string $separator)
 */
class CaseInsensitiveUnicodeSubstringList extends AbstractUnicodeSubstringList implements CaseInsensitiveInterface
{

    /**
     * 
     * @return CaseSensitiveUnicodeSubstringList
     */
    public function toCaseSensitive()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

}
