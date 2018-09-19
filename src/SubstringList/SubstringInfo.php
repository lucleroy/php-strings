<?php

namespace LucLeroy\Strings\SubstringList;

use LucLeroy\Strings\StringInterface;

class SubstringInfo
{

    /**
     *
     * @var SubstringListInterface
     */
    private $substringList;
    private $index;
    private $start;
    private $end;

    /**
     * 
     * @param int $index
     * @param int $start
     * @param int $end
     * @param SubstringListInterface $substringList
     */
    function __construct($index, $start, $end, $substringList)
    {
        $this->index = $index;
        $this->start = $start;
        $this->end = $end;
        $this->substringList = $substringList;
    }

    /**
     * Returns the index of the current substring in the substring list.
     * 
     * @return int
     */
    public function index()
    {
        return $this->index;
    }

    /**
     * Returns the index of the first character of the  current substring in the original string.
     * 
     * @return int
     */
    public function start()
    {
        return $this->start;
    }

    /**
     * Returns the index of the first character after the last character of the  current substring in the original string.
     * 
     * @return int
     */
    public function end()
    {
        return $this->end;
    }

    /**
     * Returns the substring length.
     * 
     * @return int
     */
    public function length()
    {
        return $this->end - $this->start;
    }

    /**
     * Determines if the substring is the first substring in the substring list.
     * 
     * @return bool
     */
    public function isFirst()
    {
        return $this->index === 0;
    }

    /**
     * Determines if the substring is the last substring in the substring list.
     * 
     * @return bool
     */
    public function isLast()
    {
        return $this->index === $this->substringList->count() - 1;
    }

    /**
     * Determines if the substring is at the beginning of the original string.
     * 
     * @return bool
     */
    public function isAtLeft()
    {
        return $this->start === 0;
    }

    /**
     * Determines if the substring is at the end of the original string.
     * 
     * @return bool
     */
    public function isAtRight()
    {
        return $this->end === $this->substringList->getString()->length();
    }

    /**
     * Returns the original string.
     * 
     * @return StringInterface
     */
    public function fullString()
    {
        return $this->substringList->getString();
    }

    /**
     * Returns the substring list.
     * 
     * @return SubstringListInterface
     */
    public function list()
    {
        return $this->substringList;
    }

    /**
     * Returns the string before the current substring.
     * 
     * @return StringInterface
     */
    public function before()
    {
        return $this->substringList->beforeSubstringAt($this->index);
    }

    /**
     * Returns the string after the current substring.
     * 
     * @return StringInterface
     */
    public function after()
    {
        return $this->substringList->afterSubstringAt($this->index);
    }
}
