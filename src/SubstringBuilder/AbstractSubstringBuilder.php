<?php

namespace LucLeroy\Strings\SubstringBuilder;

use LucLeroy\Regex\Regex;
use LucLeroy\Strings\StringInterface;

abstract class AbstractSubstringBuilder implements SubstringBuilderInterface
{

    protected $parent;
    protected $str;
    protected $len;
    protected $from;
    protected $to;
    protected $offset;

    public function __construct(StringInterface $string, $offset = 0, $from = 0, $to = null)
    {
        $this->parent = $string;
        $this->str = $string->toString();
        $this->offset = $offset;
        $this->len = $string->length() - $offset;
        $this->from = $from;
        $this->to = $to
            ?? $this->len;
    }

    public function getParent()
    {
        return $this->parent;
    }

    /**
     * 
     * @param int $from
     * @param int $to
     * @return SubstringBuilderInterface
     */
    protected abstract function makeSubstringBuilder($from, $to);

    protected function realSelection()
    {
        $from = max(0, $this->from);
        $to = min(max(0, $this->to), $this->len);
        return [$from, $to];
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return array
     */
    public function selection()
    {
        return $this->from <= $this->to
            ? [$this->from, $this->to]
            : null;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function isEmpty()
    {
        list($from, $to) = $this->realSelection();
        return $to - $from <= 0;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return int
     */
    public function length()
    {
        return max(0, $this->to - $this->from);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function start()
    {
        return $this->from;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function end()
    {
        return $this->to;
    }

    public function __toString()
    {
        return $this->toString();
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return StringInterface
     */
    public function remove()
    {
        return $this->patch('');
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return SubstringBuilderInterface
     */
    public function select($offset = 0)
    {
        return $this->build()->select($offset);
    }

    protected function normalizeIndex($index)
    {
        if ($index < 0) {
            $index += $this->len;
        }
        return $index;
    }

//    protected function strpos($substring, $offset = 0)
//    {
//        $pos = strpos($this->str, $substring, $this->offset + $offset);
//        if ($pos !== false) {
//            $pos -= $this->offset;
//        }
//        return $pos;
//    }
//
//    protected function strrpos($substring, $offset = 0)
//    {
//        $pos = strrpos($this->str, $substring, $this->offset + $offset);
//        if ($pos !== false) {
//            $pos -= $this->offset;
//        }
//        return $pos;
//    }
//
//    protected function strlen($string)
//    {
//        return strlen($string);
//    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function from($index)
    {
        $from = $this->normalizeIndex($index);
        return $this->makeSubstringBuilder($from, $this->to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function fromLeft()
    {
        return $this->from(0);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function fromFirst($substring)
    {
        $from = $this->strpos($substring);
        if ($from === false) {
            $from = INF;
        }
        return $this->makeSubstringBuilder($from, $this->to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function fromLast($substring)
    {
        $from = $this->strrpos($substring);
        if ($from === false) {
            $from = INF;
        }
        return $this->makeSubstringBuilder($from, $this->to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function after($index)
    {
        $from = $this->normalizeIndex($index) + 1;
        return $this->makeSubstringBuilder($from, $this->to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function afterFirst($substring)
    {
        $from = $this->strpos($substring);
        if ($from === false) {
            $from = INF;
        } else {
            $from += $this->strlen($substring);
        }
        return $this->makeSubstringBuilder($from, $this->to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function afterLast($substring)
    {
        $str = $this->str;
        $from = $this->strrpos($substring);
        if ($from === false) {
            $from = INF;
        } else {
            $from += $this->strlen($substring);
        }
        return $this->makeSubstringBuilder($from, $this->to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function to($index)
    {
        $to = $this->normalizeIndex($index) + 1;
        return $this->makeSubstringBuilder($this->from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function toRight()
    {
        return $this->to(-1);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function toNext($substring, $includeStart = false)
    {
        if ($this->from < INF) {
            $to = $this->strpos($substring,
                $includeStart
                ? $this->from
                : $this->from + 1);
            if ($to === FALSE) {
                $to = -INF;
            } else {
                $to += $this->strlen($substring);
            }
        } else {
            $to = -INF;
        }

        return $this->makeSubstringBuilder($this->from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function toLast($substring)
    {
        $to = $this->strrpos($substring);
        if ($to === FALSE) {
            $to = -INF;
        } else {
            $to += $this->strlen($substring);
        }
        return $this->makeSubstringBuilder($this->from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function before($index)
    {
        $to = $this->normalizeIndex($index);
        return $this->makeSubstringBuilder($this->from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function beforeNext($substring, $includeStart = false)
    {
        if ($this->from < INF) {
            $to = $this->strpos($substring,
                $includeStart
                ? $this->from
                : $this->from + 1);
            if ($to === FALSE) {
                $to = -INF;
            }
        } else {
            $to = -INF;
        }

        return $this->makeSubstringBuilder($this->from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function beforeLast($substring)
    {
        $to = $this->strrpos($substring);
        if ($to === FALSE) {
            $to = -INF;
        }
        return $this->makeSubstringBuilder($this->from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function betweenSubstrings($open, $close, $match = false)
    {
        $regex = $this->regexForBetween($open, $close, $match);
        preg_match($regex, $this->str, $matches, PREG_OFFSET_CAPTURE, $this->byteOffset());
        if (isset($matches[0])) {
            $from = $this->byteToCharIndex($matches[0][1]) - $this->offset;
            $to = $from + $this->strlen($matches[0][0]);
        } else {
            $from = INF;
            $to = -INF;
        }
        return $this->makeSubstringBuilder($from, $to);
    }

    /**
     * 
     * @param string $open
     * @param string $close
     * @param bool $match
     * @return Regex
     */
    protected function regexForBetween($open, $close, $match = false)
    {
        if ($match) {
            return Regex::create()
                    ->literal($open)
                    ->literalAlt([$open, $close])->notAfter()
                    ->anyChar()
                    ->group(2)->atomic()->anyTimes()
                    ->matchRecursive()
                    ->alt(2)->anyTimes()
                    ->literal($close);
        } else {
            return Regex::create()
                    ->lazy()
                    ->literal($open)
                    ->anyChar()->anyTimes()
                    ->literal($close);
        }
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function insideSubstrings($open, $close, $match = false)
    {
        $regex = $this->regexForBetween($open, $close, $match);
        preg_match($regex, $this->str, $matches, PREG_OFFSET_CAPTURE, $this->byteOffset());
        if (isset($matches[0])) {
            $from = $this->byteToCharIndex($matches[0][1]) - $this->offset;
            $to = $from + $this->strlen($matches[0][0]);
            $from += $this->strlen($open);
            $to -= $this->strlen($close);
        } else {
            $from = INF;
            $to = -INF;
        }
        return $this->makeSubstringBuilder($from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function grow($count)
    {
        $from = $this->from - $count;
        $to = $this->to + $count;
        return $this->makeSubstringBuilder($from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function shiftLeft($count)
    {
        $from = $this->from + $count;
        return $this->makeSubstringBuilder($from, $this->to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function shiftRight($count)
    {
        $to = $this->to + $count;
        return $this->makeSubstringBuilder($this->from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function shrink($count)
    {
        $from = $this->from + $count;
        $to = $this->to - $count;
        return $this->makeSubstringBuilder($from, $to);
    }

    protected function charsForComparison($string)
    {
        return $this->parent->replace($string)->chars();
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function longestCommonPrefix($string)
    {
        $from = 0;
        if (empty($string)) {
            $to = 0;
        } else {
            $thisChars = array_slice($this->charsForComparison($this->str), $this->offset);
            $stringChars = $this->charsForComparison($string);
            $diff = array_diff_assoc($stringChars, $thisChars);
            $to = key($diff);
        }
        return $this->makeSubstringBuilder($from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function longestCommonSuffix($string)
    {
        $to = $this->len;
        if (empty($string)) {
            $from = $to;
        } else {
            $thisChars = array_reverse(array_slice($this->charsForComparison($this->str), $this->offset));
            $stringChars = array_reverse($this->charsForComparison($string));
            $diff = array_diff_assoc($stringChars, $thisChars);
            $from = $this->normalizeIndex($to - key($diff));
        }
        return $this->makeSubstringBuilder($from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function longestCommonSubstring($string)
    {
        $chars1 = array_slice($this->charsForComparison($this->str), $this->offset);
        $chars2 = $this->charsForComparison($string);

        $len1 = count($chars1);
        $len2 = count($chars2);

        if ($len1 === 0 || $len2 === 0) {
            return $this->makeSubstringBuilder(0, 0);
        }

        $current = array_fill(0, $len2, 0);
        $maxLen = 0;
        $from = 0;

        foreach ($chars1 as $i => $char1) {
            foreach ($chars2 as $j => $char2) {
                if ($char1 === $char2) {
                    if ($i === 0 || $j === 0) {
                        $len = 1;
                    } else {
                        $len = $previous[$j - 1] + 1;
                    }
                    $current[$j] = $len;
                    if ($len > $maxLen) {
                        $maxLen = $len;
                        $currentStart = $i - $len + 1;
                        if ($from !== $currentStart) {
                            $from = $currentStart;
                        }
                    }
                }
            }
            $previous = $current;
            $current = array_fill(0, $len2, 0);
        }

        return $this->makeSubstringBuilder($from, $from + $maxLen);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function first($substring)
    {
        $from = $this->strpos($substring);
        if ($from === false) {
            $from = INF;
            $to = -INF;
        } else {
            $to = $from + $this->strlen($substring);
        }
        return $this->makeSubstringBuilder($from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function last($substring)
    {
        $from = $this->strrpos($substring);
        if ($from === false) {
            $from = INF;
            $to = -INF;
        } else {
            $to = $from + $this->strlen($substring);
        }
        return $this->makeSubstringBuilder($from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function at($index)
    {
        $from = $this->normalizeIndex($index);
        $to = $from;
        return $this->makeSubstringBuilder($from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function atStartOfFirst($substring)
    {
        $from = $this->strpos($substring);
        if ($from === false) {
            $from = INF;
            $to = -INF;
        } else {
            $to = $from;
        }
        return $this->makeSubstringBuilder($from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function atEndOfFirst($substring)
    {
        $from = $this->strpos($substring);
        if ($from === false) {
            $from = INF;
            $to = -INF;
        } else {
            $from += $this->strlen($substring);
            $to = $from;
        }
        return $this->makeSubstringBuilder($from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function atStartOfLast($substring)
    {
        $from = $this->strrpos($substring);
        if ($from === false) {
            $from = INF;
            $to = -INF;
        } else {
            $to = $from;
        }
        return $this->makeSubstringBuilder($from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function atEndOfLast($substring)
    {
        $from = $this->strrpos($substring);
        if ($from === false) {
            $from = INF;
            $to = -INF;
        } else {
            $from += $this->strlen($substring);
            $to = $from;
        }
        return $this->makeSubstringBuilder($from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function toLength($length)
    {
        $from = $this->from;
        $to = $from + $length;
        return $this->makeSubstringBuilder($from, $to);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function fromLength($length)
    {
        $to = $this->to;
        $from = $to - $length;
        return $this->makeSubstringBuilder($from, $to);
    }

}
