<?php

namespace LucLeroy\Strings\CaseTransformer;

use LucLeroy\Strings\StringInterface;

class SimpleCaseTransformer extends AbstractContextCaseTransformer {

    const CASE_SAME = 'same';
    const CASE_LOWER = 'lower';
    const CASE_UPPER = 'upper';
    const CASE_TITLE = 'title';

    private $case = null;
    private $caseFirst = null;
    private $sep = [
        [null, null],
        [null, null]
    ];
    private $prefixNumberFirst = '';

    public function __construct($case = null, $caseFirst = null, $sep = null, $sepNumber = null, $sepWordNumber = null,
        $sepNumberWord = null, $prefixNumberFirst = null) {
        $this->case = $case
            ?? self::CASE_SAME;
        $this->caseFirst = $caseFirst
            ?? $this->case;
        $sep = $sep
            ?? '';
        $this->sep[false][false] = $sep;
        $sepNumber = $sepNumber
            ?? $sep;
        $this->sep[true][true] = $sepNumber;
        $sepWordNumber = $sepNumberWord
            ?? $sepNumber;
        $this->sep[false][true] = $sepWordNumber;
        $sepNumberWord = $sepNumberWord
            ?? $sepNumber;
        $this->sep[true][false] = $sepWordNumber;
        $this->prefixNumberFirst = $prefixNumberFirst
            ?? '';
    }

    public function transformPart(StringInterface $current, StringInterface $previous = null,
        StringInterface $next = null) {

        $currentIsNumber = ctype_digit($current->toString());

        if (isset($next)) {
            $nextIsNumber = ctype_digit($next->toString());
            $sep = $this->sep[$currentIsNumber][$nextIsNumber];
        } else {
            $sep = '';
        }

        $prefix = '';

        if ($currentIsNumber) {
            $case = self::CASE_SAME;
            if (!isset($previous)) {
                $prefix = $this->prefixNumberFirst;
            }
        } elseif (isset($previous)) {
            $case = $this->case;
        } else {
            $case = $this->caseFirst;
        }

        return $this->changeCase($current, $case)->append($sep)->prepend($prefix);
    }

    private function changeCase(StringInterface $string, $case) {
        switch ($case) {
            case self::CASE_LOWER:
                return $string->lower();
            case self::CASE_UPPER:
                return $string->upper();
            case self::CASE_TITLE:
                return $string->lower()->upperFirst();
            default:
                return $string;
        }
    }

}
