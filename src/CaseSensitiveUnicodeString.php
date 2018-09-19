<?php

namespace LucLeroy\Strings;

use LucLeroy\Strings\SubstringBuilder\CaseSensitiveUnicodeSubstringBuilder;
use LucLeroy\Strings\SubstringList\CaseSensitiveUnicodeSubstringList;

class CaseSensitiveUnicodeString extends AbstractUnicodeString implements CaseSensitiveInterface
{

    /**
     * 
     * @return static
     */
    protected function makeString($string)
    {
        return new CaseSensitiveUnicodeString($this->decodeString($string), $this->encoding, $this->parent);
    }

    /**
     * 
     * @return CaseSensitiveUnicodeSubstringList
     */
    protected function makeExplodeSubstringList($strings, $delimiter)
    {
        return CaseSensitiveUnicodeSubstringList::create($this->alternateString($strings, $delimiter), $this);
    }

    /**
     * 
     * @return CaseSensitiveUnicodeSubstringList
     */
    protected function makeAlternatedSubstringList($strings)
    {
        return CaseSensitiveUnicodeSubstringList::create($strings, $this);
    }

    /**
     * 
     * @return CaseInsensitiveUnicodeString
     */
    public function toCaseInsensitive()
    {
        return new CaseInsensitiveUnicodeString($this->str, $this->encoding, $this->parent);
    }

    /**
     * 
     * @return CaseSensitiveBinaryString
     */
    public function toBinary()
    {
        return new CaseSensitiveBinaryString($this->toString());
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveUnicodeSubstringBuilder
     */
    public function select($offset = 0)
    {
        return new CaseSensitiveUnicodeSubstringBuilder($this, $offset);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function startsWith($substring)
    {
        if (empty($substring)) {
            return true;
        } elseif ($this->isEmpty()) {
            return false;
        }
        $substring = $this->encodeString($substring);
        return substr_compare($this->str, $substring, 0, strlen($substring)) === 0;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function endsWith($substring)
    {
        if (empty($substring)) {
            return true;
        } elseif ($this->isEmpty()) {
            return false;
        }
        $substring = $this->encodeString($substring);
        return substr_compare($this->str, $substring, -strlen($substring), PHP_INT_MAX) === 0;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function contains($substring)
    {
        return strpos($this->str, $this->encodeString($substring)) !== false;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function isSubstringOf($string)
    {
        return strpos($this->encodeString($string), $this->str) !== false;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveUnicodeSubstringList
     */
    public function explode($delimiter, $limit = PHP_INT_MAX)
    {
        $delimiter = $this->encodeString($delimiter);
        $substrings = explode($delimiter, $this->str, $limit);
        return $this->makeExplodeSubstringList($substrings, $delimiter);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function is($string)
    {
        return strcmp($this->str, $this->encodeString($string)) === 0;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function replaceAll($search, $replace)
    {
        return $this->makeString(str_replace($this->encodeStrings($search), $this->encodeStrings($replace), $this->str));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return int
     */
    public function countOf($substring)
    {
        return substr_count($this->str, $this->encodeString($substring));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveUnicodeSubstringList
     */
    public function occurences($substrings)
    {
        if (!is_array($substrings)) {
            $substrings = func_get_args();
        }
        $substrings = $this->encodeStrings($substrings);
        $regex = $this->regexForSubstrings($substrings);
        $strings = preg_split("/($regex)/u", $this->str, -1, PREG_SPLIT_DELIM_CAPTURE);
        return $this->makeAlternatedSubstringList($strings);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveUnicodeSubstringList
     */
    public function separate($delimiters)
    {
        if (!is_array($delimiters)) {
            $delimiters = func_get_args();
        }
        $delimiters = $this->encodeStrings($delimiters);
        $regex = $this->regexForSubstrings($delimiters);
        $strings = preg_split("/($regex)/u", $this->str, -1, PREG_SPLIT_DELIM_CAPTURE);
        array_unshift($strings, '');
        return $this->makeAlternatedSubstringList($strings);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveUnicodeSubstringList
     */
    public function split($size = 1)
    {
        return parent::split($size);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveUnicodeSubstringList
     */
    public function lines()
    {
        return parent::lines();
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveBinarySubstringList
     */
    public function cut($cuts)
    {
        return parent::cut($cuts);
    }

}
