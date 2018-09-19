<?php

namespace LucLeroy\Strings\CaseTransformer;

use LucLeroy\Strings\StringInterface;

abstract class AbstractContextCaseTransformer implements CaseTransformerInterface {

    public function transform($parts) {
        $previous = null;
        $current = array_shift($parts);
        $result = $current->clear();
        foreach ($parts as $next) {
            $result = $result->append($this->transformPart($current, $previous, $next));
            $previous = $current;
            $current = $next;
        }
        $next = null;
        $result = $result->append($this->transformPart($current, $previous, $next));
        return $result;
    }

    public abstract function transformPart(StringInterface $current, StringInterface $previous = null, StringInterface $next = null);

}
