<?php

namespace LucLeroy\Strings\SubstringBuilder;

use LucLeroy\Strings\StringInterface;

interface SubstringBuilderInterface
{

    public function getParent();
    
    /**
     * Returns the current selected substring as an ordinary string.
     * 
     * @return string
     */
    public function toString();

    /**
     * Returns the current selection.
     * 
     * @return array|null
     */
    public function selection();

    /**
     * 
     * @return bool
     */
    public function isEmpty();

    /**
     * Returns the length of the current selection.
     * 
     * @return int
     */
    public function length();

    /**
     * Returns the index of the first character of the current selection.
     * 
     * @return int
     */
    public function start();

    /**
     * Returns the index of the character following the last character of the current selection.
     * @return int
     */
    public function end();

    /**
     * Returns a StringInterface from the current selected substring.
     * 
     * @return StringInterface
     */
    public function build();

    /**
     * Replaces the selected substring with the given string in the original string.
     * 
     * @param string $patch
     * @return StringInterface
     */
    public function patch($patch);

    /**
     * Removes the selected substring from the original string.
     * 
     * @return StringInterface
     */
    public function remove();

    /**
     * 
     * @param int $offset
     * @return static
     */
    public function select($offset = 0);

    /**
     * 
     * @param int $index
     * @return static
     */
    public function from($index);

    /**
     * 
     * @param string $substring
     * @return static
     */
    public function fromFirst($substring);

    /**
     * 
     * @param string $substring
     * @return static
     */
    public function fromLast($substring);

    /**
     * 
     * @param int $index
     * @return static
     */
    public function after($index);

    /**
     * 
     * @param string $substring
     * @return static
     */
    public function afterFirst($substring);

    /**
     * 
     * @param string $substring
     * @return static
     */
    public function afterLast($substring);

    /**
     * 
     * @param int $index
     * @return static
     */
    public function to($index);

    /**
     * 
     * @param int $index
     * @return static
     */
    public function before($index);

    /**
     * 
     * @param string $substring
     * @param bool $includeStart
     * @return static
     */
    public function toNext($substring, $includeStart = false);

    /**
     * 
     * @param string $substring
     * @return static
     */
    public function toLast($substring);

    /**
     * 
     * @param string $substring
     * @param bool $includeStart
     * @return static
     */
    public function beforeNext($substring, $includeStart = false);

    /**
     * 
     * @param string $substring
     * @return static
     */
    public function beforeLast($substring);

    /**
     * 
     * @return static
     */
    public function fromLeft();

    /**
     * 
     * @return static
     */
    public function toRight();

    /**
     * 
     * @param string $open
     * @param string $close
     * @param bool $match
     * @return static
     */
    public function betweenSubstrings($open, $close, $match = false);

    /**
     * 
     * @param string $open
     * @param string $close
     * @param bool $match
     * @return static
     */
    public function insideSubstrings($open, $close, $match = false);

    /**
     * 
     * @param int $count
     * @return static
     */
    public function shiftLeft($count);

    /**
     * 
     * @param int $count
     * @return static
     */
    public function shiftRight($count);

    /**
     * 
     * @param int $count
     * @return static
     */
    public function grow($count);

    /**
     * 
     * @param int $count
     * @return static
     */
    public function shrink($count);

    /**
     * 
     * @param string $string
     * @return static
     */
    public function longestCommonPrefix($string);

    /**
     * 
     * @param string $string
     * @return static
     */
    public function longestCommonSuffix($string);

    /**
     * 
     * @param string $string
     * @return static
     */
    public function longestCommonSubstring($string);

    /**
     * 
     * @param string $substring
     * @return static
     */
    public function first($substring);

    /**
     * 
     * @param string $substring
     * @return static
     */
    public function last($substring);
    
    /**
     * 
     * @param int $index
     * return static
     */
    public function at($index);
    
    /**
     * 
     * @param string $substring
     * @return static
     */
    public function atStartOfFirst($substring);
    
    /**
     * 
     * @param string $substring
     * @return static
     */
    public function atEndOfFirst($substring);
    
    /**
     * 
     * @param string $substring
     * @return static
     */
    public function atStartOfLast($substring);
    
    /**
     * 
     * @param string $substring
     * @return static
     */
    public function atEndOfLast($substring);
    
    /**
     * 
     * @param int $length
     * @return static
     */
    public function toLength($length);
    
    /**
     * 
     * @param int $length
     * @return static
     */
    public function fromLength($length);
}
