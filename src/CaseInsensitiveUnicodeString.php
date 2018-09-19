<?php

namespace LucLeroy\Strings;

use LucLeroy\Strings\SubstringBuilder\CaseInsensitiveUnicodeSubstringBuilder;
use LucLeroy\Strings\SubstringList\CaseInsensitiveUnicodeSubstringList;
use function mb_stripos;
use function mb_strtolower;
use function mb_strtoupper;

class CaseInsensitiveUnicodeString extends AbstractUnicodeString implements CaseInsensitiveInterface
{

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    protected function makeString($string)
    {
        return new CaseInsensitiveUnicodeString((string) $string, $this->encoding, $this->parent);
    }

    /**
     * 
     * @return CaseInsensitiveUnicodeSubstringList
     */
    protected function makeExplodeSubstringList($strings, $delimiter)
    {
        return CaseInsensitiveUnicodeSubstringList::create($this->alternateString($strings, $delimiter), $this);
    }

    /**
     * 
     * @return CaseInsensitiveUnicodeSubstringList
     */
    protected function makeAlternatedSubstringList($strings)
    {
        return CaseInsensitiveUnicodeSubstringList::create($strings, $this);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveUnicodeSubstringBuilder
     */
    public function select($offset = 0)
    {
        return new CaseInsensitiveUnicodeSubstringBuilder($this, $offset);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseSensitiveUnicodeString
     */
    public function toCaseSensitive()
    {
        return new CaseSensitiveUnicodeString($this->str, $this->encoding, $this->parent);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return BinaryStringInterface
     */
    public function toBinary()
    {
        return new CaseInsensitiveBinaryString($this->toString());
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
        return substr_compare(mb_strtolower($this->str, self::ENCODING)
                , mb_strtolower($substring, self::ENCODING), 0, strlen($substring)) === 0;
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
        return substr_compare(mb_strtolower($this->str, self::ENCODING)
                , mb_strtolower($substring, self::ENCODING), -strlen($substring), PHP_INT_MAX) === 0;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function contains($substring)
    {
        return mb_stripos($this->str, $substring, 0, self::ENCODING) !== false;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return bool
     */
    public function isSubstringOf($string)
    {
        return mb_stripos($string, $this->str, 0, self::ENCODING) !== false;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveUnicodeSubstringList
     */
    public function explode($delimiter, $limit = PHP_INT_MAX)
    {
        $delimiter = mb_strtolower($delimiter, self::ENCODING);
        if ($delimiter === mb_strtoupper($delimiter, self::ENCODING)) {
            $substrings = explode($delimiter, $this->str, $limit);
        } else {
            $str = mb_strtolower($this->str, self::ENCODING);
            $substrings = explode($delimiter, $str, $limit);
            $len = strlen($delimiter);
            $offset = 0;
            foreach ($substrings as &$value) {
                $l = strlen($value);
                $value = substr($this->str, $offset, $l);
                $offset += $len + $l;
            }
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
        $lcString = mb_strtolower($string, self::ENCODING);
        return strcmp(mb_strtolower($this->str, self::ENCODING), $lcString) === 0;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function replaceAll($search, $replace)
    {
        if (is_array($search)) {
            foreach ($search as &$item) {
                $item = "/$item/imuS";
            }
        } else {
            $search = "/$search/imuS";
        }
        return $this->makeString(preg_replace($search, $replace, $this->str));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return int
     */
    public function countOf($substring)
    {
        return substr_count(mb_strtolower($this->str, self::ENCODING), mb_strtolower($substring, self::ENCODING));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveUnicodeSubstringList
     */
    public function occurences($substrings)
    {
        if (!is_array($substrings)) {
            $substrings = func_get_args();
        }
        $regex = $this->regexForSubstrings($substrings);
        $strings = preg_split("/($regex)/ui", $this->str, -1, PREG_SPLIT_DELIM_CAPTURE);
        return $this->makeAlternatedSubstringList($strings);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveUnicodeSubstringList
     */
    public function separate($delimiters)
    {
        if (!is_array($delimiters)) {
            $delimiters = func_get_args();
        }
        $regex = $this->regexForSubstrings($delimiters);
        $strings = preg_split("/($regex)/ui", $this->str, -1, PREG_SPLIT_DELIM_CAPTURE);
        array_unshift($strings, '');
        return $this->makeAlternatedSubstringList($strings);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveUnicodeSubstringList
     */
    public function split($size = 1)
    {
        return parent::split($size);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveUnicodeSubstringList
     */
    public function lines()
    {
        return parent::lines();
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return CaseInsensitiveUnicodeSubstringList
     */
    public function cut($cuts)
    {
        return parent::cut($cuts);
    }

}
