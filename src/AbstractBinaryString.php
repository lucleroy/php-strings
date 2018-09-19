<?php

namespace LucLeroy\Strings;

use LucLeroy\Regex\Regex;
use LucLeroy\Strings\SubstringList\SubstringListInterface;

abstract class AbstractBinaryString extends AbstractString implements BinaryStringInterface
{

    protected static $regexForCaseTransform;

    public function __construct($string, $parent = null)
    {
        $this->str = $string;
        $this->parent = $parent;
    }

    /**
     * 
     * @param string $string
     * @return static
     */
    public static function create($string = '')
    {
        return new static($string);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return string
     */
    public function toString()
    {
        return $this->str;
    }

    protected function encodeString($string)
    {
        return (string) $string;
    }
    
    protected function decodeString($string)
    {
        return (string) $string;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return int
     */
    public function length()
    {
        return strlen($this->str);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return string
     */
    public function lower()
    {
        return $this->makeString(strtolower($this->str));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function reverse()
    {
        return $this->makeString(strrev($this->str));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function upper()
    {
        return $this->makeString(strtoupper($this->str));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function center($size, $fill = ' ')
    {
        return $this->makeString(str_pad($this->str, $size, $fill, STR_PAD_BOTH));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function alignLeft($size, $fill = ' ')
    {
        return $this->makeString(str_pad($this->str, $size, $fill, STR_PAD_RIGHT));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function alignRight($size, $fill = ' ')
    {
        return $this->makeString(str_pad($this->str, $size, $fill, STR_PAD_LEFT));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function trim($charlist = null)
    {
        if ($charlist === null) {
            return $this->makeString(trim($this->str));
        } else {
            return $this->makeString(trim($this->str, $charlist));
        }
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function trimLeft($charlist = null)
    {
        if ($charlist === null) {
            return $this->makeString(ltrim($this->str));
        } else {
            return $this->makeString(ltrim($this->str, $charlist));
        }
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function trimRight($charlist = null)
    {
        if ($charlist === null) {
            return $this->makeString(rtrim($this->str));
        } else {
            return $this->makeString(rtrim($this->str, $charlist));
        }
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function truncate($size, $string = '')
    {
        if ($this->length() <= $size) {
            return $this;
        }
        $str = $this->substr($this->str, 0, $size - strlen($string)) . $string;
        return $this->makeString($str);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function truncateLeft($size, $string = '')
    {
        if ($this->length() <= $size) {
            return $this;
        }
        $str = $string . $this->substr($this->str, strlen($string) - $size);
        return $this->makeString($str);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function truncateMiddle($size, $string = '')
    {
        if ($this->length() <= $size) {
            return $this;
        }
        $size -= strlen($string);
        $leftSize = floor($size / 2);
        $str = $this->substr($this->str, 0, $leftSize) . $string . $this->substr($this->str, $leftSize - $size);
        return $this->makeString($str);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function shuffle()
    {
        return $this->makeString(str_shuffle($this->str));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return array
     */
    public function chars()
    {
        return empty($this->str)
            ? []
            : str_split($this->str);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return string
     */
    public function charAt($index)
    {
        return $this->str[$index];
    }

    /**
     * 
     * {@inheritdoc}
     * 
     */
    public function cut($cuts)
    {
        if (!is_array($cuts)) {
            $cuts = func_get_args();
        }
        $len = $this->length();
        foreach ($cuts as &$cut) {
            if ($cut < 0) {
                $cut += $len;
            }
        }
        unset($cut);
        sort($cuts);
        $start = 0;
        $cuts[] = $len;
        $pieces = [];
        foreach ($cuts as $cut) {
            $pieces[] = $this->substr($this->str, $start, $cut - $start);
            $start = $cut;
        }
        return $this->makeExplodeSubstringList($pieces, '');
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function lowerFirst()
    {
        return $this->makeString(lcfirst($this->str));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function upperFirst()
    {
        return $this->makeString(ucfirst($this->str));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return SubstringListInterface
     */
    public function split($size = 1)
    {
        return $this->makeExplodeSubstringList(str_split($this->str, $size), '');
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function fill($size, $fill = ' ')
    {
        return $this->makeString(str_pad('', $size, $fill));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function repeatToSize($size)
    {
        return $this->makeString(str_pad('', $size, $this->str));
    }

    protected function strlen($string)
    {
        return strlen($string);
    }

    protected function substr($string, $start, $length = null)
    {
        if (isset($length)) {
            return substr($string, $start, $length);
        } else {
            return substr($string, $start);
        }
    }

    protected function regexForCaseTransform()
    {
        if (!isset(self::$regexForCaseTransform)) {
            self::$regexForCaseTransform = Regex::create()
                ->chars('a..z')->atLeastOne()
                ->chars('A..Z')->chars('a..z')->atLeastOne()->group(2)
                ->chars('A..Z')->atLeastOne()
                ->digit()->atLeastOne()
                ->alt(4)
                ->getOptimizedRegex();
        }
        return self::$regexForCaseTransform;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function titleize()
    {
        return $this->makeString(ucwords(strtolower($this->str)));
    }

    /**
     * {@inheritdoc}
     * 
     * @return static
     */
    public function escapeControlChars()
    {
        return $this->makeString(addcslashes($this->str, "\0..\37\177"));
    }
    
    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function patch()
    {
        if (isset($this->parent)) {
            $result = $this->parent->patch($this);
            return new static($this->encodeString($this->parent->patch($this)), $result->parent);
        }
        return $this;
    }

}
