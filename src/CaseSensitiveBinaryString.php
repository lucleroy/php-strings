<?php

namespace LucLeroy\Strings;

use LucLeroy\Strings\SubstringBuilder\CaseSensitiveBinarySubstringBuilder;
use LucLeroy\Strings\SubstringList\CaseSensitiveBinarySubstringList;

class CaseSensitiveBinaryString extends AbstractBinaryString implements CaseSensitiveInterface
{

    /**
     * 
     * @return CaseSensitiveBinaryString
     */
    protected function makeString($string)
    {
        return new CaseSensitiveBinaryString((string) $string, $this->parent);
    }

    /**
     * 
     * @return CaseSensitiveBinarySubstringList
     */
    protected function makeExplodeSubstringList($strings, $delimiter)
    {
        return CaseSensitiveBinarySubstringList::create($this->alternateString($strings, $delimiter), $this);
    }

    /**
     * 
     * @return CaseSensitiveBinarySubstringList
     */
    protected function makeAlternatedSubstringList($strings)
    {
        return CaseSensitiveBinarySubstringList::create($strings, $this);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveBinaryString
     */
    public function toCaseInsensitive()
    {
        return new CaseInsensitiveBinaryString($this->str, $this->parent);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveUnicodeString
     */
    public function toUnicode($encoding = 'UTF-8')
    {
        return new CaseSensitiveUnicodeString($this->str, $encoding);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveBinarySubstringBuilder
     */
    public function select($offset = 0)
    {
        return new CaseSensitiveBinarySubstringBuilder($this, $offset);
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
        return strpos($this->str, $substring) !== false;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function isSubstringOf($string)
    {
        return strpos($string, $this->str) !== false;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveBinarySubstringList
     */
    public function explode($delimiter, $limit = PHP_INT_MAX)
    {
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
        return strcmp($this->str, $string) === 0;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function replaceAll($search, $replace)
    {
        return $this->makeString(str_replace($search, $replace, $this->str));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function countOf($substring)
    {
        return substr_count($this->str, $substring);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveBinarySubstringList
     */
    public function occurences($substrings)
    {
        if (!is_array($substrings)) {
            $substrings = func_get_args();
        }
        $regex = $this->regexForSubstrings($substrings);
        $strings = preg_split("/($regex)/", $this->str, -1, PREG_SPLIT_DELIM_CAPTURE);
        return $this->makeAlternatedSubstringList($strings);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveBinarySubstringList
     */
    public function separate($delimiters)
    {
        if (!is_array($delimiters)) {
            $delimiters = func_get_args();
        }
        $regex = $this->regexForSubstrings($delimiters);
        $strings = preg_split("/($regex)/", $this->str, -1, PREG_SPLIT_DELIM_CAPTURE);
        array_unshift($strings, '');
        return $this->makeAlternatedSubstringList($strings);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveBinarySubstringList
     */
    public function split($size = 1)
    {
        return parent::split($size);
    }
    
    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveBinarySubstringList
     */
    public function lines()
    {
        return parent::lines();
    }
    
    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveBinarySubstringList
     */
    public function cut($cuts)
    {
        return parent::cut($cuts);
    }

}
