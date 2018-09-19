<?php

namespace LucLeroy\Strings;

use LucLeroy\Regex\Regex;
use LucLeroy\Regex\Unicode;
use LucLeroy\Strings\SubstringList\SubstringListInterface;
use function mb_strlen;
use function mb_strtolower;
use function mb_strtoupper;
use function mb_substr;

abstract class AbstractUnicodeString extends AbstractString implements UnicodeStringInterface
{

    protected static $regexForCaseTransform;
    protected $encoding;
    protected $cacheLength = null;

    public function __construct($string = '', $encoding = 'UTF-8', $parent = null)
    {
        $this->str = $encoding === self::ENCODING
            ? $string
            : mb_convert_encoding($string, self::ENCODING, $encoding);
        $this->parent = $parent;
        $this->encoding = $encoding;
    }

    /**
     * 
     * @param string $string
     * @return static
     */
    public static function create($string = '', $encoding = 'UTF-8')
    {
        return new static($string, $encoding);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function toEncoding($encoding)
    {
        return $encoding === self::ENCODING
            ? $this
            : static::create(mb_convert_encoding($this->str, $encoding, self::ENCODING), $encoding);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return string
     */
    public function toString()
    {
        return $this->encoding === self::ENCODING
            ? $this->str
            : mb_convert_encoding($this->str, $this->encoding, self::ENCODING);
    }

    protected function strlen($string)
    {
        return mb_strlen($string, self::ENCODING);
    }

    protected function encodeString($string)
    {
        if (is_string($string)) {
            return $this->encoding === self::ENCODING
                ? $string
                : mb_convert_encoding($string, self::ENCODING, $this->encoding);
        } elseif ($string instanceof UnicodeStringInterface) {
            $stringEncoding = $string->getEncoding();
            return $stringEncoding === self::ENCODING
                ? $string
                : mb_convert_encoding($string, self::ENCODING, $stringEncoding);
        } else {
            return (string) $string;
        }
    }
    
    protected function decodeString($string)
    {
        return $this->encoding === self::ENCODING
                ? $string
                : mb_convert_encoding($string, $this->encoding, self::ENCODING); 
    }

    protected function substr($string, $start, $length = null)
    {
        return mb_substr($string, $start, $length, self::ENCODING);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return int
     */
    public function length()
    {
        if (!isset($this->cacheLength)) {
            $this->cacheLength = mb_strlen($this->str, self::ENCODING);
        }
        return $this->cacheLength;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function lower()
    {
        return $this->makeString(mb_strtolower($this->str, self::ENCODING));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function reverse()
    {
        $chars = preg_split('//u', $this->str, -1, PREG_SPLIT_NO_EMPTY);
        $str = implode('', array_reverse($chars));
        return $this->makeString($str);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function upper()
    {
        return $this->makeString(mb_strtoupper($this->str, self::ENCODING));
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function center($size, $fill = ' ')
    {
        $fill = $this->encodeString($fill);
        $diff = $size - $this->length();
        if ($diff > 0) {
            $left = floor($diff / 2);
            $right = $diff - $left;
            $fillLength = mb_strlen($fill, self::ENCODING);
            $leftPadding = $left > 0
                ? mb_substr(str_repeat($fill, ceil($left / $fillLength)), 0, $left, self::ENCODING)
                : '';
            $rightPadding = mb_substr(str_repeat($fill, ceil($right / $fillLength)), 0, $right, self::ENCODING);
            return $this->makeString($leftPadding . $this->str . $rightPadding);
        }
        return $this;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function alignRight($size, $fill = ' ')
    {
        $fill = $this->encodeString($fill);
        $diff = $size - $this->length();
        if ($diff > 0) {
            $fillLength = mb_strlen($fill, self::ENCODING);
            $padding = mb_substr(str_repeat($fill, ceil($diff / $fillLength)), 0, $diff, self::ENCODING);
            return $this->makeString($padding . $this->str);
        }
        return $this;
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function alignLeft($size, $fill = ' ')
    {
        $fill = $this->encodeString($fill);
        $diff = $size - $this->length();
        if ($diff > 0) {
            $fillLength = mb_strlen($fill, self::ENCODING);
            $padding = mb_substr(str_repeat($fill, ceil($diff / $fillLength)), 0, $diff, self::ENCODING);
            return $this->makeString($this->str . $padding);
        }
        return $this;
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
            $charlist = preg_quote($this->encodeString($charlist), '/');
            $str = preg_replace('/^[' . $charlist . ']+/u', '', $this->str);
            return $this->makeString($str);
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
            $charlist = preg_quote($this->encodeString($charlist), '/');
            $str = preg_replace('/[' . $charlist . ']+$/u', '', $this->str);
            return $this->makeString($str);
        }
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
            $charlist = preg_quote($this->encodeString($charlist), '/');
            $str = preg_replace('/^[' . $charlist . ']+|[' . $charlist . ']+$/u', '', $this->str);
            return $this->makeString($str);
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
        $str = mb_strimwidth($this->str, 0, $size, $this->encodeString($string), self::ENCODING);
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
        $str = $this->encodeString($string) . $this->substr($this->str, strlen($string) - $size);
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
        $string = $this->encodeString($string);
        $size -= strlen($string);
        $leftSize = floor($size / 2);
        $str = $this->substr($this->str, 0, $leftSize) . $string . $this->substr($this->str, $leftSize - $size);
        return $this->makeString($str);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return SubstringListInterface
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
    public function shuffle()
    {
        $chars = preg_split('//u', $this->str, -1, PREG_SPLIT_NO_EMPTY);
        shuffle($chars);
        $str = implode('', $chars);
        return $this->makeString($str);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return array
     */
    public function chars()
    {
        return preg_split('//u', $this->str, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return string
     */
    public function charAt($index)
    {
        return $this->substr($this->str, $index, 1);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function lowerFirst()
    {
        $str = mb_strtolower(mb_substr($this->str, 0, 1, self::ENCODING), self::ENCODING)
            . mb_substr($this->str, 1, null, self::ENCODING);
        return $this->makeString($str);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function upperFirst()
    {
        $str = mb_strtoupper(mb_substr($this->str, 0, 1, self::ENCODING), self::ENCODING)
            . mb_substr($this->str, 1, null, self::ENCODING);
        return $this->makeString($str);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return SubstringListInterface
     */
    public function split($size = 1)
    {
        $array = [];
        $offset = 0;
        $len = $this->length();
        while ($offset < $len) {
            $array[] = mb_substr($this->str, $offset, $size, self::ENCODING);
            $offset += $size;
        }
        return $this->makeExplodeSubstringList($array, '');
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function fill($size, $fill = ' ')
    {
        $fill = $this->encodeString($fill);
        $fillLength = mb_strlen($fill, self::ENCODING);
        $str = mb_substr(str_repeat($fill, ceil($size / $fillLength)), 0, $size, self::ENCODING);
        return $this->makeString($str);
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function repeatToSize($size)
    {
        if ($this->isEmpty()) {
            return $this;
        }
        $str = mb_substr(str_repeat($this->str, ceil($size / $this->length())), 0, $size, self::ENCODING);
        return $this->makeString($str);
    }

    protected function regexForCaseTransform()
    {
        if (!isset(self::$regexForCaseTransform)) {
            self::$regexForCaseTransform = Regex::create()
                ->unicode(Unicode::LetterLower)->atLeastOne()
                ->unicode(Unicode::LetterUpper)->unicode(Unicode::LetterTitle)->alt(2)->unicode(Unicode::LetterLower)->atLeastOne()->group(2)
                ->unicode(Unicode::LetterUpper)->unicode(Unicode::LetterTitle)->alt(2)->atLeastOne()
                ->digit()->atLeastOne()
                ->alt(4)
                ->getUtf8OptimizedRegex();
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
        return $this->makeString(mb_convert_case($this->str, MB_CASE_TITLE, self::ENCODING));
    }

    /**
     * {@inheritdoc}
     * 
     * @return static
     */
    public function escapeControlChars()
    {
        return $this->makeString(addcslashes($this->str, "\0..\37\177\180..\237"));
    }
    
    
    /**
     * {@inheritdoc}
     * 
     * @return static
     */
    public function ascii()
    {
        return $this->makeString(transliterator_transliterate('Any-Latin; Latin-ASCII', $this->str));
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
            return new static($this->encodeString($this->parent->patch($this)), $result->getEncoding(), $result->parent);
        }
        return $this;
    }

}
