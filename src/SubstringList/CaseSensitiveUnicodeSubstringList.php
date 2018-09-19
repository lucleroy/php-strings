<?php

namespace LucLeroy\Strings\SubstringList;

use LucLeroy\Strings\CaseSensitiveInterface;

/**
 * @method CaseSensitiveUnicodeString implode(string $separator)
 */
class CaseSensitiveUnicodeSubstringList extends AbstractUnicodeSubstringList implements CaseSensitiveInterface
{

    /**
     * 
     * @return CaseInsensitiveUnicodeSubstringList
     */
    public function toCaseInsensitive()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

}
