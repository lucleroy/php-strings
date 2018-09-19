<?php

namespace LucLeroy\Strings;

use LucLeroy\Strings\CaseTransformer\CaseTransformerInterface;
use LucLeroy\Strings\SubstringBuilder\SubstringBuilderInterface;
use LucLeroy\Strings\SubstringList\SubstringListInterface;

interface StringInterface
{

    /**
     * Applies changes made to the substring to the parent string.
     * If the string is not a substring, return $this.
     * 
     * @param string $patch
     * @return static
     */
    public function patch();

    /**
     * Convert to an ordinary string.
     * 
     * @return string
     */
    public function toString();

    /**
     * Start the selection of a substring.
     * 
     * @param int $offset
     * @return SubstringBuilderInterface
     */
    public function select($offset = 0);

    /**
     * Return the length of the string.
     * 
     * @return int
     */
    public function length();

    /**
     * Create an empty string.
     * 
     * @return static
     */
    public function clear();

    /**
     * Create a new string with specified content.
     * 
     * @param string $string
     * @return static
     */
    public function replace($string);

    /**
     * Add another string to the end.
     * 
     * @param string $string
     * @return static
     */
    public function append($string);

    /**
     * Add another to the beginning.
     * 
     * @param string $string
     * @return static
     */
    public function prepend($string);

    /**
     * Convert to uppercase.
     * 
     * @return static
     */
    public function upper();

    /**
     * Convert to lowercase.
     * 
     * @return static
     */
    public function lower();

    /**
     * Reverse the characters.
     * 
     * @return static
     */
    public function reverse();

    /**
     * Repeat the string.
     * 
     * @param int $multiplier
     * @return static
     */
    public function repeat($multiplier = 2);

    /**
     * Pad to a given size with another string so that the string is aligned to the left.
     * 
     * @param int $size
     * @param string $fill
     * @return static
     */
    public function alignLeft($size, $fill = ' ');

    /**
     * Pad to a given size with another string so that the string is aligned to the right.
     * 
     * @param int $size
     * @param string $fill
     * @return static
     */
    public function alignRight($size, $fill = ' ');

    /**
     * Pad to a given size with another string so that the string is centered.
     * 
     * @param int $size
     * @param string $fill
     * @return static
     */
    public function center($size, $fill = ' ');

    /**
     * Strip whitespaces (or given characters) from the beginning.
     * 
     * @param string $charlist
     * @return static
     */
    public function trimLeft($charlist = null);

    /**
     * Strip whitespaces (or given characters) from the end.
     * 
     * @param string $charlist
     * @return static
     */
    public function trimRight($charlist = null);

    /**
     * Strip whitespaces (or given characters) from both the beginning an the end.
     * 
     * @param string $charlist
     * @return static
     */
    public function trim($charlist = null);

    /**
     * Truncate on the right to a specified size. If a non-empty string is given,
     * deleted characters are replaced with it (additional characters are remove
     * so that the length of the string does not exceed the given size).
     * 
     * @param int $size
     * @param string $string
     * @return static
     */
    public function truncate($size, $string = '');

    /**
     * Truncate on the left to a specified size. If a non-empty string is given,
     * deleted characters are replaced with it (additional characters are remove
     * so that the length of the string does not exceed the given size).
     * 
     * @param int $size
     * @param string $string
     * @return static
     */
    public function truncateLeft($size, $string = '');

    /**
     * Truncate on the middle to a specified size. If a non-empty string is given,
     * deleted characters are replaced with it (additional characters are remove
     * so that the length of the string does not exceed the given size).
     * 
     * @param int $size
     * @param string $string
     * @return static
     */
    public function truncateMiddle($size, $string = '');

    /**
     * Randomly shuffles the string.
     * 
     * @return static
     */
    public function shuffle();

    /**
     * Return an array with the characters (as ordinary strings) of the string.
     * 
     * @return array
     */
    public function chars();

    /**
     * Return the character (as an ordinary string) at the specified index.
     * 
     * @param int $index
     * @return string
     */
    public function charAt($index);

    /**
     * Cut the string at specified positions.
     * 
     * @param array $cuts
     * @return SubstringListInterface
     */
    public function cut($cuts);

    /**
     * Determine if the string is empty
     * 
     * @return bool
     */
    public function isEmpty();

    /**
     * Determine if the string starts with a given substring.
     * 
     * @param string $substring
     * @return bool
     */
    public function startsWith($substring);

    /**
     * Determine if the string starts with any of the given substrings.
     * 
     * @param array $substrings
     * @return bool
     */
    public function startsWithAny($substrings);

    /**
     * Determine if the string ends with a given substring.
     * 
     * @param string $substring
     * @return bool
     */
    public function endsWith($substring);

    /**
     * Determine if the string starts with any of the given substrings.
     * 
     * @param array $substrings
     * @return bool
     */
    public function endsWithAny(array $substrings);

    /**
     * Add a substring to the beginning if the string does not already start with it.
     * 
     * @param string $substring
     * @return static
     */
    public function ensureLeft($substring);

    /**
     * Add a substring to the end if the string does not already end with it.
     * 
     * @param string $substring
     * @return static
     */
    public function ensureRight($substring);

    /**
     * Convert the first character to uppercase.
     * 
     * @return static
     */
    public function upperFirst();

    /**
     * Convert the first character to lowercase.
     * 
     * @return static
     */
    public function lowerFirst();

    /**
     * Extract words and digit sequences then combine them according to the given transformer.
     * 
     * @param CaseTransformerInterface
     * @return static
     */
    public function caseTransform($transformer);

    /**
     * Determine if the string contains a given substring.
     * 
     * @param string $substring
     * @return bool
     */
    public function contains($substring);

    /**
     * Determine if the string contains all the given substrings.
     * 
     * @param array $substrings
     * @return bool
     */
    public function containsAll(array $substrings);

    /**
     * Determine if the string contains any of the given substrings.
     * 
     * @param array $substring
     * @return bool
     */
    public function containsAny(array $substring);

    /**
     * Determine if the string is a substring of a given string.
     * 
     * @param string $string
     * @return bool
     */
    public function isSubstringOf($string);

    /**
     * Determine if the string is a substring of any of the given strings.
     * 
     * @param array $strings
     * @return bool
     */
    public function isSubstringOfAny($strings);

    /**
     * Determine if the string is a substring of all the given strings.
     * 
     * @param array $strings
     * @return bool
     */
    public function isSubstringOfAll($strings);

    /**
     * Split by a delimiter.
     * 
     * @param string $delimiter
     * @param int $limit
     * @return SubstringListInterface
     */
    public function explode($delimiter, $limit = PHP_INT_MAX);

    /**
     * Determine if the string equal to another string.
     * 
     * @param string $string
     * @return bool
     */
    public function is($string);

    /**
     * Determine if the string is equal to any of the given strings.
     * 
     * @param array $strings
     * @return bool
     */
    public function isAny($strings);

    /**
     * Determine if the string contains only ASCII characters.
     * 
     * @return bool
     */
    public function isAscii();

    /**
     * Split to lines.
     * 
     * @return SubstringListInterface
     */
    public function lines();

    /**
     * Split the string in substrings of same specified size.
     * 
     * @param int $size
     * @return SubstringListInterface
     */
    public function split($size = 1);

    /**
     * Replace consecutive occurences of a character with one character only.
     * 
     * @param string $char
     * @return static
     */
    public function squeeze($char = ' ');

    /**
     * Add one string to the beginning and another (or the same) to the end.
     * 
     * @param string $string1
     * @param string $string2
     * @return static
     */
    public function surroundWith($string1, $string2 = null);

    /**
     * Replace all occurrences of the search string(s) with the replacement string(s).
     * 
     * @param string|array $search
     * @param string|array $replace
     * @return static
     */
    public function replaceAll($search, $replace);

    /**
     * Create a string with the given size and fill it with another string.
     * 
     * @param int $size
     * @param string $fill
     * @return static
     */
    public function fill($size, $fill = ' ');

    /**
     * Repeat the string up to the given size.
     * 
     * @param int $size
     * @return static
     */
    public function repeatToSize($size);

    /**
     * Escape control characters.
     * 
     * @return static
     */
    public function escapeControlChars();

    /**
     * Return the number of occurences of the given substring.
     * 
     * @param string $substring
     * @return int
     */
    public function countOf($substring);

    /**
     * Return all occurences of the given substring(s).
     * 
     * @param string|array $substring
     * @return SubstringListInterface
     */
    public function occurences($substrings);

    /**
     * Split by multiple delimiters. 
     * 
     * @param string|array $substring
     * @return SubstringListInterface
     */
    public function separate($delimiters);

    /**
     * Convert first word of each word to uppercase, and the others to lowercase.
     * 
     * @return static
     */
    public function titleize();

    /**
     * Apply a custom tranformation to the string.
     * The result must have the same properties as the current string.
     * If it is not true, it is converted.
     * 
     * @param callable $callable
     * @return static
     */
    public function transform($callable);

    /**
     * Apply a custom tranformation to the string.
     * The result can be anything.
     * 
     * @param callable $callable
     * @return mixed
     */
    public function convert($callable);

}
