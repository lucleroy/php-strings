<?php

namespace LucLeroy\Strings;

interface CaseSensitiveInterface
{

    /**
     * @return CaseInsensitiveInterface
     */
    public function toCaseInsensitive();
}
