<?php

namespace LucLeroy\Strings\SubstringList;

use LucLeroy\Strings\UnicodeStringInterface;

class AbstractUnicodeSubstringList extends AbstractSubstringList implements UnicodeStringInterface
{

    public function ascii()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    public function getEncoding()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    public function toBinary()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    public function toEncoding($encoding)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

}
