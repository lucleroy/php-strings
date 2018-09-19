<?php

class BasicCaseTransformer implements \LucLeroy\Strings\CaseTransformer\CaseTransformerInterface
{
    public function transform($parts): \LucLeroy\Strings\StringInterface
    {
        return $parts[0]->replace(implode('|', $parts));
    }

}
