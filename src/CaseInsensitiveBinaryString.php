<?php

namespace LucLeroy\Strings;

use LucLeroy\Strings\SubstringBuilder\CaseInsensitiveBinarySubstringBuilder;
use LucLeroy\Strings\SubstringList\CaseInsensitiveBinarySubstringList;

class CaseInsensitiveBinaryString extends AbstractBinaryString implements CaseInsensitiveInterface
{

    /**
     * 
     * {@inheritdoc}
     */
    protected function makeString($string)
    {
        return new CaseInsensitiveBinaryString((string) $string, $this->parent);
    }

    /**
     * 
     * @return CaseInsensitiveBinarySubstringList
     */
    protected function makeExplodeSubstringList($strings, $delimiter)
    {
        return CaseInsensitiveBinarySubstringList::create($this->alternateString($strings, $delimiter), $this);
    }

    /**
     * 
     * @return CaseInsensitiveBinarySubstringList
     */
    protected function makeAlternatedSubstringList($strings)
    {
        return CaseInsensitiveBinarySubstringList::create($strings, $this);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveBinarySubstringBuilder
     */
    public function select($offset = 0)
    {
        return new CaseInsensitiveBinarySubstringBuilder($this, $offset);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveBinaryString
     */
    public function toCaseSensitive()
    {
        return new CaseSensitiveBinaryString($this->str, $this->parent);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveUnicodeString
     */
    public function toUnicode($encoding = 'UTF-8')
    {
        return new CaseInsensitiveUnicodeString($this->str, $encoding);
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
        return substr_compare(strtolower($this->str)
                , strtolower($substring), 0, strlen($substring)) === 0;
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
        return substr_compare(strtolower($this->str)
                , strtolower($substring), -strlen($substring), PHP_INT_MAX) === 0;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function contains($substring)
    {
        return stripos($this->str, $substring) !== false;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function isSubstringOf($string)
    {
        return stripos($string, $this->str) !== false;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveBinarySubstringList
     */
    public function explode($delimiter, $limit = PHP_INT_MAX)
    {
        $str = str_ireplace($delimiter, $delimiter, $this->str);
        $substrings = explode($delimiter, $str, $limit);
        if ($limit > 0 && count($substrings) === $limit) {
            $substrings[] = substr($this->str, -strlen(array_pop($substrings)));
        }
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
        return strcasecmp($this->str, $string) === 0;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function replaceAll($search, $replace)
    {
        return $this->makeString(str_ireplace($search, $replace, $this->str));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return int
     */
    public function countOf($substring)
    {
        return substr_count(strtolower($this->str), strtolower($substring));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveBinarySubstringList
     */
    public function occurences($substrings)
    {
        if (!is_array($substrings)) {
            $substrings = func_get_args();
        }
        $regex = $this->regexForSubstrings($substrings);
        $strings = preg_split("/($regex)/i", $this->str, -1, PREG_SPLIT_DELIM_CAPTURE);
        return $this->makeAlternatedSubstringList($strings);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveBinarySubstringList
     */
    public function separate($delimiters)
    {
        if (!is_array($delimiters)) {
            $delimiters = func_get_args();
        }
        $regex = $this->regexForSubstrings($delimiters);
        $strings = preg_split("/($regex)/i", $this->str, -1, PREG_SPLIT_DELIM_CAPTURE);
        array_unshift($strings, '');
        return $this->makeAlternatedSubstringList($strings);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveBinarySubstringList
     */
    public function split($size = 1)
    {
        return parent::split($size);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveBinarySubstringList
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
