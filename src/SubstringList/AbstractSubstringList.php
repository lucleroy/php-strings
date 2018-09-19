<?php

namespace LucLeroy\Strings\SubstringList;

use LucLeroy\Strings\CaseInsensitiveBinaryString;
use LucLeroy\Strings\CaseInsensitiveUnicodeString;
use LucLeroy\Strings\CaseSensitiveBinaryString;
use LucLeroy\Strings\CaseSensitiveUnicodeString;
use LucLeroy\Strings\StringInterface;

class AbstractSubstringList implements SubstringListInterface, StringInterface
{

    protected $strings;
    protected $parent;
    protected $cache = [];

    /**
     * 
     * @param array $strings
     * @param StringInterface $parent
     */
    public function __construct(array $strings, $parent)
    {
        $this->strings = $strings;
        $this->parent = $parent;
    }

    /**
     * 
     * @param array $strings
     * @param StringInterface $parent
     * @return static
     */
    public static function create($strings, $parent)
    {
        $instance = new static($strings, $parent);
        $isSubstring = false;
        foreach ($instance->strings as &$string) {
            if ($isSubstring && is_string($string)) {
                $string = $parent->replace($string);
            }
            $isSubstring = !$isSubstring;
        }
        return $instance;
    }

    protected function getSubstringIterator($strings) {
        $isSubstring = false;
        foreach ($strings as $string) {
            if ($isSubstring) {
                yield $string;
            }
            $isSubstring = !$isSubstring;
        }
    }
    
    /**
     * 
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->strings) >> 1;
    }

    public function patch()
    {
        return $this->parent->replace(implode('', $this->strings));
    }

    protected function mapMethod($method, $args)
    {
        $strings = $this->strings;
        if (isset($strings[1])) {
            $isSubstring = false;
            foreach ($strings as &$string) {
                if ($isSubstring) {
                    $string = call_user_func_array([$string, $method], $args);
                }
                $isSubstring = !$isSubstring;
            }
            return $this->createConcrete($strings);
        }
        return $this;
    }

    protected function createConcrete($strings)
    {
        $first = $strings[1];
        if ($first instanceof StringInterface) {
            if ($first instanceof CaseSensitiveBinaryString) {
                return new CaseSensitiveBinarySubstringList($strings, $this->parent);
            }
            if ($first instanceof CaseInsensitiveBinaryString) {
                return new CaseInsensitiveBinarySubstringList($strings, $this->parent);
            }
            if ($first instanceof CaseSensitiveUnicodeString) {
                return new CaseSensitiveUnicodeSubstringList($strings, $this->parent);
            }
            if ($first instanceof CaseInsensitiveUnicodeString) {
                return new CaseInsensitiveUnicodeSubstringList($strings, $this->parent);
            }
        }
        return iterator_to_array($this->getSubstringIterator($strings));
    }

    public function toArray()
    {
        return iterator_to_array($this->getSubstringIterator($this->strings));
    }

    /**
     * 
     * @param string $separator
     * @return StringInterface
     */
    public function implode($separator = '')
    {
        return $this->parent->replace(implode($separator, $this->toArray()));
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function remove()
    {
        return $this->clear()->patch();
    }

    private function mapInfo($callable, $args = null)
    {
        $substringCount = count($this->strings) >> 1;
        $stringLength = $this->parent->length();
        $result = [];
        $start = 0;
        $isSubstring = false;
        $index = 0;
        foreach ($this->strings as $string) {
            if ($isSubstring) {
                $len = $string->length();
                $end = $start + $len;
                $info = new SubstringInfo($index, $start, $end, $this);
                if (isset($callable)) {
                    $result[] = $callable($string, $info, $args);
                } else {
                    $result[] = $info;
                }
                $start += $len;
                $index++;
            } else {
                $result[] = $string;
                $start += $this->parent->replace($string)->length();
            }
            $isSubstring = !$isSubstring;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getString()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        return $this->info(self::INFO_START);
    }

    /**
     * {@inheritdoc}
     */
    public function end()
    {
        return $this->info(self::INFO_END);
    }

    protected function infoWithTemplate($string, SubstringInfo $info, $template)
    {
        if (!isset($template)) {
            return $info;
        }

        $isArray = is_array($template);
        if (!$isArray) {
            $template = [$template];
        }

        $result = [];
        foreach ($template as $key => $infoType) {
            switch ($infoType) {
                case self::INFO_STRING:
                    $result[$key] = $string;
                    break;
                case self::INFO_START:
                    $result[$key] = $info->start();
                    break;
                case self::INFO_END:
                    $result[$key] = $info->end();
                    break;
                case self::INFO_LENGTH:
                    $result[$key] = $info->length();
                    break;
                default:
                    break;
            }
        }

        if ($isArray) {
            return $result;
        }

        return $result[0];
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function info($template = null)
    {
        $result = [];
        $isSubstring = false;
        foreach ($this->mapInfo([$this, 'infoWithTemplate'], $template) as $entry) {
            if ($isSubstring) {
                $result[] = $entry;
            }
            $isSubstring = !$isSubstring;
        }
        return $result;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function transform($callable)
    {
        $strings = $this->mapInfo($callable);
        foreach ($strings as &$string) {
            $string = $this->parent->replace($string);
        }
        return new static($strings, $this->parent);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function convert($callable)
    {
        $result = [];
        $isSubstring = false;
        foreach ($this->mapInfo($callable) as $entry) {
            if ($isSubstring) {
                $result[] = $entry;
            }
            $isSubstring = !$isSubstring;
        }
        return $result;
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function afterSubstringAt($index): StringInterface
    {
        return $this->getStringAt($index * 2 + 2);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function beforeSubstringAt($index): StringInterface
    {
        return $this->getStringAt($index * 2);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function substringAt($index): StringInterface
    {
        return $this->strings[$index * 2 + 1];
    }

    public function getStringAt($index)
    {   
        $str = $this->strings[$index] ?? '';
        return $this->parent->replace($str);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function alignLeft($size, $fill = ' ')
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function alignRight($size, $fill = ' ')
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function append($string)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function toString()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function caseTransform($transformer)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function center($size, $fill = ' ')
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function charAt($index)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function chars()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function clear()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function contains($substring)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function containsAll(array $substrings)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function containsAny(array $substring)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function isSubstringOf($string): bool
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function isSubstringOfAll($strings): bool
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function isSubstringOfAny($strings): bool
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     * 
     */
    public function cut($cuts)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function endsWith($substring)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function endsWithAny(array $substrings)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function ensureLeft($substring)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function ensureRight($substring)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function explode($delimiter, $limit = PHP_INT_MAX)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function fill($size, $fill = ' ')
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function is($string)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function isAny($strings)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function isAscii()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function length()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function lines()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function lower()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function lowerFirst()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function prepend($string)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function repeat($multiplier = 2)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function repeatToSize($size)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function replace($string)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function replaceAll($search, $replace)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @return static
     */
    public function reverse()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function select($offset = 0)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function shuffle()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function split($size = 1)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function squeeze($char = ' ')
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function startsWith($substring)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function startsWithAny($substrings)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function surroundWith($string1, $string2 = null)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function surroundWithHtmlTag($tag, array $attributes = array())
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function trim($charlist = null)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function trimLeft($charlist = null)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function trimRight($charlist = null)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function truncate($size, $string = '')
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function truncateLeft($size, $string = '')
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function truncateMiddle($size, $string = '')
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function upper()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function upperFirst()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function escapeControlChars()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function countOf($substring): int
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function occurences($substrings)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function separate($delimiters)
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function titleize()
    {
        return $this->mapMethod(__FUNCTION__, func_get_args());
    }

}
