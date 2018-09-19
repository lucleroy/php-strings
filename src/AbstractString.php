<?php

namespace LucLeroy\Strings;

use LucLeroy\Regex\Charset;
use LucLeroy\Regex\Regex;
use LucLeroy\Strings\CaseTransformer\CaseTransformerFactory;
use LucLeroy\Strings\SubstringList\SubstringListInterface;

abstract class AbstractString implements StringInterface
{

    protected static $regexForHasOnlyOneByteChars;
    protected $parent;
    protected $str;

    protected abstract function encodeString($string);

    protected function encodeStrings($strings)
    {
        if (is_array($strings)) {
            $result = [];
            foreach ($strings as $string) {
                $result[] = $this->encodeString($string);
            }
            return $result;
        }
        return $this->encodeString($strings);
    }
    
    protected abstract function decodeString($string);

    /**
     * 
     * @param string $string*
     * @return static
     */
    protected abstract function makeString($string);

    /**
     * @return SubstringListInterface
     */
    protected abstract function makeExplodeSubstringList($strings, $delimiter);

    /**
     * @return SubstringListInterface
     */
    protected abstract function makeAlternatedSubstringList($strings);

    protected function alternateString($substrings, $rest)
    {
        if (is_array($rest)) {
            $result = [reset($rest)];
            foreach ($substrings as $string) {
                $result[] = $string;
                $result[] = next($rest);
            }
        } else {
            $result = [];
            foreach ($substrings as $string) {
                $result[] = $rest;
                $result[] = $string;
            }
            $result[] = '';
            $result[0] = '';
        }
        return $result;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function __toString()
    {
        return $this->toString();
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function clear()
    {
        return $this->makeString('');
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function append($string)
    {
        if (!empty($string)) {
            return $this->makeString($this->str . $this->encodeString($string));
        }
        return $this;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function prepend($string)
    {
        if (!empty($string)) {
            return $this->makeString($this->encodeString($string) . $this->str);
        }
        return $this;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function replace($string)
    {
        return $this->makeString($this->encodeString($string));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function repeat($multiplier = 2)
    {
        return $this->makeString(str_repeat($this->str, $multiplier));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function isEmpty()
    {
        return !isset($this->str[0]);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function caseTransform($transformer)
    {
        $regex = $this->regexForCaseTransform();
        $matches = null;
        preg_match_all($regex, $this->str, $matches);
        if (isset($matches[0])) {
            $parts = [];
            foreach ($matches[0] as $value) {
                $parts[] = $this->makeString($value);
            }
            return $transformer->transform($parts);
        } else {
            return $this->clear();
        }
    }

    abstract protected function regexForCaseTransform();

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function isAscii()
    {
        $regex = Regex::create()
            ->ansiRange(0x80, 0xff)
            ->getOptimizedRegex();
        return !preg_match($regex, $this->str);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return SubstringListInterface
     */
    public function lines()
    {
        $strings = preg_split('/(\r\n|\r|\n)/', $this->str, -1, PREG_SPLIT_DELIM_CAPTURE);
        array_unshift($strings, '');
        return $this->makeAlternatedSubstringList($strings);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function surroundWith($string1, $string2 = null)
    {
        if (isset($string2)) {
            $str = $this->encodeString($string1) . $this->str . $this->encodeString($string2);
        } else {
            $string1 = $this->encodeString($string1);
            $str = $string1 . $this->str . $string1;
        }
        return $this->makeString($str);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function isAny($strings)
    {
        foreach ($strings as $string) {
            if ($this->is($this->encodeString($string))) {
                return true;
            }
        }
        return false;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function containsAll(array $substrings)
    {
        foreach ($substrings as $substring) {
            if (!$this->contains($this->encodeString($substring))) {
                return false;
            }
        }
        return true;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function containsAny(array $substrings)
    {
        foreach ($substrings as $substring) {
            if ($this->contains($this->encodeString($substring))) {
                return true;
            }
        }
        return false;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function isSubstringOfAll($strings): bool
    {
        foreach ($strings as $string) {
            if (!$this->isSubstringOf($this->encodeString($string))) {
                return false;
            }
        }
        return true;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function isSubstringOfAny($strings): bool
    {
        foreach ($strings as $string) {
            if ($this->isSubstringOf($this->encodeString($string))) {
                return true;
            }
        }
        return false;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function ensureLeft($substring)
    {
        $substring = $this->encodeString($substring);
        if (!$this->startsWith($substring)) {
            return $this->makeString($substring . $this->str);
        }
        return $this;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function ensureRight($substring)
    {
        $substring = $this->encodeString($substring);
        if (!$this->endsWith($substring)) {
            return $this->makeString($this->str . $substring);
        }
        return $this;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function endsWithAny(array $substrings)
    {
        foreach ($substrings as $substring) {
            if ($this->endsWith($this->encodeString($substring))) {
                return true;
            }
        }
        return false;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function startsWithAny($substrings)
    {
        foreach ($substrings as $substring) {
            if ($this->startsWith($this->encodeString($substring))) {
                return true;
            }
        }
        return false;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function squeeze($char = ' ')
    {
        $char = $this->encodeString($char);
        $pieces = explode($char, $this->str);
        if ($pieces[0] === '') {
            $str = $char;
        } else {
            $str = '';
        }
        foreach ($pieces as $piece) {
            if ($piece !== '') {
                $str .= $piece . $char;
            }
        }
        if ($piece !== '') {
            $str = substr($str, 0, -strlen($char));
        }
        return $this->makeString($str);
    }

    protected function regexForSubstrings($substrings)
    {
        $compare = function($a, $b) {
            return strlen($b) - strlen($a);
        };
        usort($substrings, $compare);
        return implode('|', $substrings);
    }

    protected function hasOnlyOneByteChars($string)
    {
        $regex = $this->regexForHasOnlyOneByteChars();
        return !preg_match($regex, $this->string);
    }

    protected function regexForHasOnlyOneByteChars()
    {
        if (!isset(self::$regexForHasOnlyOneByteChars)) {
            self::$regexForHasOnlyOneByteChars = Regex::create()
                ->chars(Charset::create()
                    ->ansiRange(0xc2, 0xdf)
                    ->ansiRange(0xe1, 0xec)
                    ->ansiRange(0xee, 0xef)
                    ->ansiRange(0xf1, 0xf3)
                )
                ->ansi(0xe0)->ansiRange(0xa0, 0xbf)->group(2)
                ->ansi(0xed)->ansiRange(0x80, 0x8f)->group(2)
                ->ansi(0xf0)->ansiRange(0x90, 0xbf)->group(2)
                ->ansi(0xf4)->ansiRange(0x80, 0x8f)->group(2)
                ->alt()
                ->getOptimizedRegex();
        }
        return self::$regexForHasOnlyOneByteChars;
    }

    /**
     * {@inheritdoc}
     * 
     * @return static
     */
    public function transform($callable)
    {
        return $this->makeString($callable($this));
    }

    /**
     * {@inheritdoc}
     * 
     * @return mixed
     */
    public function convert($callable)
    {
        return $callable($this);
    }

}
