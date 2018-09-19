<?php

namespace LucLeroy\Strings;

interface CaseInsensitiveInterface
{

    /**
     * @return CaseSensitiveInterface
     */
    public function toCaseSensitive();
}
