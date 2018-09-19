<?php

namespace LucLeroy\Strings\SubstringList;

use Countable;
use LucLeroy\Strings\StringInterface;


interface SubstringListInterface extends Countable
{
    const INFO_STRING = 0;
    const INFO_START = 1;
    const INFO_END = 2;
    const INFO_LENGTH = 3;

    /**
     * Applies substrings changes to the original string.
     * 
     * @return StringInterface
     */
    public function patch();
    
    /**
     * Returns an array of substrings.
     * 
     * @return array
     */
    public function toArray();
    
    /**
     * Join the substrings with a separator.
     * 
     * @return StringInterface
     */
    public function implode($separator);
    
    /**
     * Remove the substrings from the original string.
     * 
     * @return StringInterface
     */
    public function remove();
    
    /**
     * Returns the indices of the first character of each substring.
     * 
     * @return array
     */
    public function start();
    
    /**
     * Returns the indices of the character following the last character of each substring.
     * 
     * @return array
     */
    public function end();
   
    /**
     * Returns information about each substring.
     * 
     * @param int|array $template
     * @return array
     */
    public function info($template = null);
       
    /**
     * Returns the original string.
     * 
     * @return StringInterface
     */
    public function getString();
    
    /**
     * Returns the substring at the specified index.
     * 
     * @param int $index
     * @return StringInterface
     */
    public function substringAt($index);
    
    /**
     * Returns the string just before the substring at the specified index (and just after the previous substring).
     * 
     * @param int $index
     * @return StringInterface
     */
    public function beforeSubstringAt($index);
    
    /**
     * Returns the string just after the substring at the specified index (and just before the next substring).
     * 
     * @param int $index
     * @return StringInterface
     */
    public function afterSubstringAt($index);
    
            
}
