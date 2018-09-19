<?php

namespace LucLeroy\Strings\CaseTransformer;

use LucLeroy\Strings\StringInterface;

interface CaseTransformerInterface {
    /**
     * 
     * @param StringInterface[] $parts
     * @return StringInterface
     */
    public function transform($parts);
}
