# PHP Strings

PHP library to manipulate strings.

## Table of contents

* [Introduction](#introduction)
* [Requirements](#require)
* [Installation](#install)
* [Usage](#usage)
    * [Basics](#usage-basics)
    * [Working with one substring](#usage-substring-builder)
    * [Working with multiple substrings](#usage-substring-list)
    * [Case transformers](#usage-case-transformers)
* [Reference](#reference)
    * [Strings](#reference-strings)
        * [alignLeft](#reference-strings-align-left)
        * [alignRight](#reference-strings-align-right)
        * [append](#reference-strings-append)
        * [ascii](#reference-strings-ascii)
        * [caseTransform](#reference-strings-case-transform)
        * [charAt](#reference-strings-char-at)
        * [center](#reference-strings-center)
        * [chars](#reference-strings-chars)
        * [clear](#reference-strings-clear)
        * [contains](#reference-strings-contains)
        * [containsAll](#reference-strings-contains-all)
        * [containsAny](#reference-strings-contains-any)
        * [convert](#reference-strings-convert)
        * [countOf](#reference-strings-count-of)
        * [cut](#reference-strings-cut)
        * [endsWith](#reference-strings-ends-with)
        * [endsWithAny](#reference-strings-ends-with-any)
        * [ensureLeft](#reference-strings-ensure-left)
        * [ensureRight](#reference-strings-ensure-right)
        * [escapeControlChars](#reference-strings-escape-control-chars)
        * [explode](#reference-strings-explode)
        * [getEncoding](#reference-strings-get-encoding)
        * [is](#reference-strings-is)
        * [isAny](#reference-strings-is-any)
        * [isAscii](#reference-strings-is-ascii)
        * [isEmpty](#reference-strings-is-empty)
        * [isSubstringOf](#reference-strings-is-substring-of)
        * [isSubstringOfAll](#reference-strings-is-substring-of-all)
        * [isSubstringOfAny](#reference-strings-is-substring-of-any)
        * [length](#reference-strings-length)
        * [lines](#reference-strings-lines)
        * [lower](#reference-strings-lower)
        * [lowerFirst](#reference-strings-lower-first)
        * [occurences](#reference-strings-occurences)
        * [patch](#reference-strings-patch)
        * [prepend](#reference-strings-prepend)
        * [repeat](#reference-strings-repeat)
        * [repeatToSize](#reference-strings-repeat-to-size)
        * [replace](#reference-strings-replace)
        * [replaceAll](#reference-strings-replace-all)
        * [reverse](#reference-strings-reverse)
        * [select](#reference-strings-select)
        * [separate](#reference-strings-separate)
        * [shuffle](#reference-strings-shuffle)
        * [split](#reference-strings-split)
        * [squeeze](#reference-strings-squeeze)
        * [startsWith](#reference-strings-starts-with)
        * [startsWithAny](#reference-strings-starts-with-any)
        * [surroundWith](#reference-strings-surround-with)
        * [titleize](#reference-strings-titleize)
        * [toString](#reference-strings-to-string)
        * [toBinary](#reference-strings-to-binary)
        * [toCaseSensitive](#reference-stringsto-case-sensitive-)
        * [toCaseInsensitive](#reference-strings-to-case-insensitive)
        * [toEncoding](#reference-strings-to-encoding)
        * [toUnicode](#reference-strings-to-unicode)
        * [transform](#reference-strings-transform)
        * [trim](#reference-strings-trim)
        * [trimLeft](#reference-strings-trim-left)
        * [trimRight](#reference-strings-trim-right)
        * [truncate](#reference-strings-truncate)
        * [truncateLeft](#reference-stringstruncate-left-)
        * [truncateMiddle](#reference-strings-truncate-middle)
        * [upper](#reference-strings-upper)
        * [upperFirst](#reference-strings-upper-first)
    * [Substring builder](#reference-substring-builder)
        * [after](#reference-substring-builder-after)
        * [afterFirst](#reference-substring-builder-after-first)
        * [afterLast](#reference-substring-builder-after-last)
        * [at](#reference-substring-builder-at)
        * [atEndOfFirst](#reference-substring-builder-at-end-of-first)
        * [atEndOfLast](#reference-substring-builder-at-end-of-last)
        * [atStartOfFirst](#reference-substring-builder-at-start-of-first)
        * [atStartOfLast](#reference-substring-builder-at-start-of-last)
        * [before](#reference-substring-builder-before)
        * [beforeLast](#reference-substring-builder-before-last)
        * [beforeNext](#reference-substring-builder-before-next)
        * [betweenSubstrings](#reference-substring-builder-between-substrings)
        * [build](#reference-substring-builder-build)
        * [end](#reference-substring-builder-end)
        * [first](#reference-substring-builder-first)
        * [from](#reference-substring-builder-from)
        * [fromFirst](#reference-substring-builder-from-first)
        * [fromLast](#reference-substring-builder-from-last)
        * [fromLeft](#reference-substring-builder-from-left)
        * [fromLength](#reference-substring-builder-from-length)
        * [grow](#reference-substring-builder-grow)
        * [insideSubstrings](#reference-substring-builder-inside-substrings)
        * [isEmpty](#reference-substring-builder-is-empty)
        * [last](#reference-substring-builder-last)
        * [length](#reference-substring-builder-length)
        * [longestCommonPrefix](#reference-substring-builder-longest-common-prefix)
        * [longestCommonSubstring](#reference-substring-builder-longest-common-substring)
        * [longestCommonSuffix](#reference-substring-builder-longest-common-suffix)
        * [patch](#reference-substring-builder-patch)
        * [remove](#reference-substring-builder-remove)
        * [select](#reference-substring-builder-select)
        * [selection](#reference-substring-builder-selection)
        * [shiftLeft](#reference-substring-builder-shift-left)
        * [shiftRight](#reference-substring-builder-shift-right)
        * [shrink](#reference-substring-builder-shrink)
        * [start](#reference-substring-builder-start)
        * [to](#reference-substring-builder-to)
        * [toLast](#reference-substring-builder-to-last)
        * [toLength](#reference-substring-builder-to-length)
        * [toNext](#reference-substring-builder-to-next)
        * [toRight](#reference-substring-builder-to-right)
        * [toString](#reference-substring-builder-to-string)
    * [Substring Lists](#reference-substring-list)
        * [afterSubstringAt](#reference-substring-list-after-substring-at)
        * [beforeSubstringAt](#reference-substring-list-before-substring-at)
        * [convert](#reference-substring-list-convert)
        * [count](#reference-substring-list-count)
        * [end](#reference-substring-list-end)
        * [getString](#reference-substring-list-get-string)
        * [implode](#reference-substring-list-implode)
        * [info](#reference-substring-list-info)
        * [patch](#reference-substring-list-patch)
        * [remove](#reference-substring-list-remove)
        * [start](#reference-substring-list-start)
        * [substringAt](#reference-substring-list-substring-at)
        * [toArray](#reference-substring-list-to-array)
        * [transform](#reference-substring-list-transform)


## <a name="introduction"></a> Introduction

This library provides an unified way to manage binary strings and Unicode strings.

```php
use function LucLeroy\Strings\s;
use function LucLeroy\Strings\u;

echo s('Hello')->upper()->reverse();        // OLLEH

echo u('Доброе утро.')->upper()->reverse(); // .ОРТУ ЕОРБОД
```

You can work with case sentive or case insensitive strings.

```php
use function LucLeroy\Strings\s;

echo s('Hello World')->contains('hello') ? 'true' : 'false';                      // false

echo s('Hello World')->toCaseInsensitive()->contains('hello') ? 'true' : 'false'; // true
```

In addition, it provides powerful methods for working with substrings.

```php
use function LucLeroy\Strings\s;

echo s('Hello World')->explode(' ')->reverse()->patch(); // olleH dlroW
```

## <a name="require"></a> Requirements

- PHP 7.
- mbstring extension.
- intl extension.

## <a name="install"></a> Installation (with Composer)

Add the following to the `require` section of your composer.json file

```
"lucleroy/php-strings": "*"
```
and run `composer update`.

## <a name="usage"></a> Usage

### <a name="usage-basics"></a> Basics

This library provides four main classes implementing `StringInterface`:

- `CaseSensitiveBinaryString` to work with case sensitive binary strings.
- `CaseInsensitiveBinaryString` to work with case insensitive binary strings.
- `CaseSensitiveUnicodeString` to work with case sensitive Unicode strings.
- `CaseInsensitiveUnicodeString` to work with case insensitive Unicode strings.

**Important note**: These classes are immutable.

Use the `create` method to create a string:

```php
use LucLeroy\Strings\CaseSensitiveBinaryString;

$str = CaseSensitiveBinaryString::create('Hello');
```

By default, Unicode strings use an UTF-8 encoding. If you want to use another encoding you can specify it as a second
arguments to `create`. You can use any encoding supporting by the `mbstring` extension (not necessary an Unicode encoding):

```php
use LucLeroy\Strings\CaseSensitiveUnicodeString;

$str = CaseSensitiveUnicodeString::create('Hello&hellip;', 'HTML-ENTITIES');

echo $str->append(' World!')->upper();   // HELLO&hellip; WORLD!
```

You can convert any type of string to any other type by using methods
`toCaseSensitive`, `toCaseInsensitive`, `toBinary`, `toUnicode`. 

Instead of using classes directly, you can use functions `s` for binary strings and `u` for Unicode strings.
These functions are shortcuts to `CaseSensitiveBinaryString:create` and `CaseSensitiveUnicodeString:create` respectively.

### <a name="usage-substring-builder"></a> Working with one substring

At first glance, it seems that this library does not provide methods for searching or extracting substrings.
This is of course wrong. But the way to work with a substring is a bit peculiar.

To work with a substring, you must first call the `select` method which create a builder (immutable):

```php
$str = s('Hello World!');

$builder = $str->select();
```

Then you use the builder methods to select a substring:

```php
$builder = $builder->first('World'); // select the substring 'World'
```

Then you can get information about the position of the substring with `selection`, `start`, `end`, `length`:

```php
echo $builder->start();              // 6
echo $builder->end();                // 11
echo $builder->length();             // 5
$selection = $builder->selection();  // $selection = [6, 11]
```

**Note**: The end of the selection is the first index after the selection.

You can also modify the substring with `patch` or remove it with `remove`:

```php
echo $builder->patch('Everybody');  // Hello Everybody!
echo $builder->remove();            // Hello !
```

You can extract the substring with `build`:

```php
$substring = $builder->build();

echo $substring;  // World
```

As `build` returns an instance of the same type than the original string, you can then transform the substring:

```php
$substring = $substring->upper();  

echo $substring;  // WORLD
```

Finally, you can reinject the modified substring into the original string with `patch`:

```php
echo $substring->patch();  // Hello WORLD!
```

Of course, you can chain operations:

```php
echo s('Hello World!')
    ->select()
    ->first('World')
    ->build()
    ->upper()
    ->patch();  // Hello WORLD!
```

### <a name="usage-substring-list"></a> Working with multiple substrings

Some methods (`explode`, `split`, `occurences`, ...) return several substrings. The result is an instance of
a class implementing `SubstringListInterface` which extends `StringInterface`, so you can use all the methods
available for strings on the result of these methods:

```php
$str = s('hello world!');

$list = $str->occurences(['h', 'w'])->upper();
```

Then use `patch` to patch the original string with the modified substrings:

```php
echo $list->patch(); //  Hello World!
```

If you don't care of the original string, you can retrieve the substrings as an array (of `StringInterface`) with `toArray`.
You can also use `implode` to join the substrings into a single `StringInterface`.

### <a name="usage-case-transformers"></a> Case transformers

If you want to transform a string to camel case, pascal case, ..., you must use the `caseTransform`.
The argument of this method must implement `CaseTransformerInterface` (in namespace `LucLeroy\Strings\CaseTransformer`).
Common transformers are available via the `CaseTransformerFactory`:

```php
use LucLeroy\Strings\CaseTransformer\CaseTransformerFactory;
use function LucLeroy\Strings\s;

$str = s('Hello World!');

$factory = CaseTransformerFactory::getInstance();

echo $str->caseTransform($factory->camel());   // helloWorld

echo $str->caseTransform($factory->pascal()); // HelloWorld

echo $str->caseTransform($factory->pascal()); // HELLO_WORLD
```

`caseTransform` keep only letter sequences and digit sequences and provides these sequences as an array of `StringInterface`.
`CaseTransformerInterface` has a method `transform` which transform this array into a `StringInterface`.

To implement your own transformer, you can implement `CaseTransformerInterface` directly.

Most of the time, you can determine how to render a sequence based on  the sequence itself and the two sequences next to it.
For example, in camel case, the first sequence must be in lowercase and others in lowercase except for the first character which must be in uppercase.
You can implement a case transformer depending only on the context by extending `AbstractContextCaseTransformer`. 
You must implement the `transformPart` method which has three arguments: the current part, the previous one, and the next one.
A basic camel case transformer can be implemented as follows:

```php
use LucLeroy\Strings\CaseTransformer\AbstractContextCaseTransformer;
use LucLeroy\Strings\StringInterface;
use function LucLeroy\Strings\s;

class CamelCaseTransformer extends AbstractContextCaseTransformer
{

    public function transformPart(
        StringInterface $current, 
        StringInterface $previous = null,
        StringInterface $next = null
    ) {
        if ($previous) {
            return $current->titleize();
        } else {
            return $current->lower();
        }
    }

}

echo s('Hello World!')->caseTransform(new CamelCaseTransformer());  // helloWorld
```

But there is even simpler: you can create a case transformer with the class `SimpleCaseTransformer`.
You can rewrite the previous camel case transformer as follows:

```php
use LucLeroy\Strings\CaseTransformer\SimpleCaseTransformer;
use function LucLeroy\Strings\s;

$camelCaseTransformer = new SimpleCaseTransformer(
    SimpleCaseTransformer::CASE_TITLE, 
    SimpleCaseTransformer::CASE_LOWER
);

echo s('Hello World!')->caseTransform($camelCaseTransformer);
```

With `SimpleCaseTransformer` you can specify a different case for the first sequence and the others, and a different separator
between diffrent types of sequences (letters or digits).

## <a name="reference"></a> Reference

### <a name="reference-strings"></a> Strings

#### <a name="reference-strings-align-left"></a> alignLeft($size, $fill = ' '): StringInterface

Returns a left-justified string of a given minimum size. The remaining space is filled with the string `$fill`;

```php
echo s('Hello')->alignLeft(10);        // 'Hello     '
echo s('Hello')->alignLeft(10, '.');   // 'Hello.....'
echo s('Hello')->alignLeft(10, '+-');  // 'Hello+-+-+'
```

#### <a name="reference-strings-align-right"></a> alignRight($size, $fill = ' '): StringInterface

Returns a right-justified string of a given minimum size. The remaining space is filled with the string `$fill`;

```php
echo s('Hello')->alignRight(10);        // '     Hello'
echo s('Hello')->alignRight(10, '.');   // '.....Hello'
echo s('Hello')->alignRight(10, '+-');  // '+-+-+Hello'
```

#### <a name="reference-strings-append"></a> append($string): StringInterface

Adds `$string` to the end of the current string.

```php
echo s('Hello')->append(' World!');  // Hello World!
```

#### <a name="reference-strings-ascii"></a> ascii(): UnicodeStringInterface

*Available for Unicode strings only.*

Converts the string to ASCII.

```php
echo u('Доброе утро.')->ascii();  // Dobroe utro.
```

#### <a name="reference-strings-case-transform"></a> caseTransform($transformer): StringInterface

Converts the string to camel case, pascal case, kebab case, ...

```php
use LucLeroy\Strings\CaseTransformer\CaseTransformerFactory;
use function LucLeroy\Strings\s;

$factory = CaseTransformerFactory::getInstance();
$camel = $factory->camel();

echo s('Hello World!')->caseTransform($camel);  // helloWorld
```

#### <a name="reference-strings-char-at"></a> charAt($index): string

Returns the character at the specified index as an ordinary string.

```php
echo s('Hello')->charAt(1);   // 'e'
```

#### <a name="reference-strings-center"></a> center($size, $fill = ' '): StringInterface

Returns a centered string of a given minimum size. The remaining space is filled with the string `$fill`;

```php
echo s('Hello')->center(10);        // '  Hello   '
echo s('Hello')->center(10, '.');   // '..Hello...'
echo s('Hello')->center(10, '+-');  // '+-Hello+-+'
```

#### <a name="reference-strings-chars"></a> chars(): string[]

Returns the characters composing the string as an array of ordinary strings.

```php
$chars = s('Hello')->chars;   // $chars = ['H', 'e', 'l', 'l', 'o']
```

#### <a name="reference-strings-clear"></a> clear(): StringInterface

Returns an empty string.

```php
echo s('Hello')->clear;   // ''
```

#### <a name="reference-strings-contains"></a> contains($substring): bool

Determines if `$substring` is a substring of the current string.

```php
echo s('Hello World!')->contains('Hello') ? 'true' : 'false';  // true
```

#### <a name="reference-strings-contains-all"></a> containsAll($substrings): bool

Determines if all the `$substring` are substrings of the current string.

```php
echo s('Hello World!')->containsAll(['Hello', 'World]) ? 'true' : 'false';  // true
echo s('Hello World!')->containsAll(['Hello', 'Everybody]) ? 'true' : 'false';  // false
```

#### <a name="reference-strings-contains-any"></a> containsAny($substrings): bool

Determines if any of the `$substring` i susbstring of the current string.

```php
echo s('Hello World!')->containsAny(['Hello', 'World]) ? 'true' : 'false';  // true
echo s('Hello World!')->containsAny(['Hello', 'Everybody]) ? 'true' : 'false';  // true
```

#### <a name="reference-strings-convert"></a> convert($callable)

Applies a custom tranformation to the string.
The result can be anything.

```php
echo u('Доброе утро.')->convert(function ($s) {
    return strlen($s);
});  // 22 (number)   
```

#### <a name="reference-strings-count-of"></a> countOf($substring): int

Returns the number of occurrences of `$substring` in the current string.

```php
echo s('To be or not to be.')->countOf('be');  // 2
```

#### <a name="reference-strings-cut"></a> cut($cuts): SubstringListInterface

Returns a `SubstringListInterface` containing the current string cut to the specified positions.

```php
$result = s('Hello World!')->cut([5, 6, 11])->toString();  // $result = ['Hello', ' ', 'World', '!']
```

#### <a name="reference-strings-ends-with"></a> endsWith($substring): bool

Determines if the current string ends with `$substring`.

```php
echo s('Hello World!')->endsWith('Hello') ? 'true' : 'false';  // false
echo s('Hello World!')->endsWith('World!') ? 'true' : 'false'; // true
```

#### <a name="reference-strings-ends-with-any"></a> endsWithAny($substrings): bool

Determines if the current string ends with any of `$substrings`.

```php
echo s('Hello World!')->endsWithAny(['Everybody!', 'World!']) ? 'true' : 'false';  // true
```

#### <a name="reference-strings-ensure-left"></a> ensureLeft($substring): StringInterface

If the current string does not start with `$substring`, adds `$substring` to the beginning of the current string.

```php
echo s('Hello World!')->ensureLeft('Hello');  // Hello World!
echo s(' World!')->ensureLeft('Hello');       // Hello World!
```

#### <a name="reference-strings-ensure-right"></a> ensureRight($substring): StringInterface

If the current string does not end with `$substring`, adds `$substring` to the end of the current string.

```php
echo s('Hello World!')->ensureRight('World!');  // Hello World!
echo s('Hello ')->ensureRight('World!');        // Hello World!
```

#### <a name="reference-strings-escape-control-chars"></a> escapeControlChars(): StringInterface

Escapes control characters.

```php
echo s("Hello\nWorld!")->escapeControlChars();  // Hello\nWorld!
```

#### <a name="reference-strings-explode"></a> explode($delimiter, $limit = PHP_INT_MAX): SubstringListInterface

Splits the string by a delimiter.  

```php
$result = s('123,456,789')->explode(',')->toString();  // $result = [123, 456, 789]
```

**Note:** For a case insensitive string, all versions of the delimiter are replaced by the gicen version:

```php
echo s('123o456O789')->toCaseInsensitive()->explode('o')->patch();  // 123o456o789
```

#### <a name="reference-strings-get-encoding"></a> getEncoding(): string

*Available for Unicode strings only.*

Returns the encoding of the string.

```php
echo u('Hello')->getEncoding();  // UTF-8
```

#### <a name="reference-strings-is"></a> is($string): bool

Determines is the string is equal to `$string`.

```php
echo s('Hello World!')->is('Hello World!') ? 'true' : 'false';                       // true
echo s('Hello World!')->is('hello world!') ? 'true' : 'false';                       // false
echo s('Hello World!')->toCaseInsensitive()->is('hello world!') ? 'true' : 'false';  // true
```

#### <a name="reference-strings-is-any"></a> isAny($strings): bool

Determines if the string is any of the `$strings`.

```php
echo s('Hello')->isAny(['hello', 'world']) ? 'true' : 'false';                       // false
echo s('Hello')->toCaseInsensitive()->isAny(['hello', 'world']) ? 'true' : 'false';  // true
```

#### <a name="reference-strings-is-ascii"></a> isAscii(): bool

Determines if the string contains only ASCII characters.

```php
echo u('Hello.')->isAscii() ? 'true' : 'false';        // true
echo u('Доброе утро.')->isAscii() ? 'true' : 'false';  // false
```

#### <a name="reference-strings-is-empty"></a> isEmpty(): bool

Determines if the string is empty.

```php
echo s('Hello.')->isEmpty() ? 'true' : 'false';           // false
echo s('Hello.')->clear()->isEmpty() ? 'true' : 'false';  // true
```

#### <a name="reference-strings-is-substring-of"></a> isSubstringOf($string): bool

Determines if the string is a substring of `$string`.

```php
echo s('Hello')->isSubstringOf('Hello World!') ? 'true' : 'false';  // true
```

#### <a name="reference-strings-is-substring-of-all"></a> isSubstringOfAll($strings): bool

Determines if the string is a substring of each of the strings in `$strings`.

```php
echo s('Hello')->isSubstringOfAll('Hello World!', 'Hello Everybody!') ? 'true' : 'false';       // true
echo s('Hello')->isSubstringOfAll('Hello World!', 'Good Morning, Vietnam') ? 'true' : 'false';  // false
```

#### <a name="reference-strings-is-substring-of-any"></a> isSubstringOfAny($strings): bool

Determines if the string is a substring of any of the strings in `$strings`.

```php
echo s('Hello')->isSubstringOfAny('Hello World!', 'Good Morning, Vietnam') ? 'true' : 'false';  // true
```

#### <a name="reference-strings-length"></a> length(): int

Returns the length of the string.

```php
echo s('Hello')->length();  // 5
```

#### <a name="reference-strings-lines"></a> lines(): SubstringListInterface

Splits the string to lines. Supported EOL are: "\n", "\r\n", "\r".

```php
$lines = s("Hello\nWorld!")->lines()->toString();  // $line s= ['Hello', 'World!']
```

#### <a name="reference-strings-lower"></a> lower(): StringInterface

Converts the string to lowercase.

```php
echo s("HELLO")->lower();  // hello
```

#### <a name="reference-strings-lower-first"></a> lowerFirst(): StringInterface

Converts the first character of the string to lowercase.

```php
echo s("HELLO")->lower();  // hELLO
```

#### <a name="reference-strings-occurences"></a> occurences($substrings): SubstringListInterface

Returns all occurences of strings in `$substrings`.

```php
echo s('Hello World!')->occurences(['o', 'l'])->implode();  // llool
```

#### <a name="reference-strings-patch"></a> patch(): StringInterface

Applies changes made to the substring to the parent string.
If the string is not a substring, return `$this`.

```php
echo s('Hello World!')
    ->select()->beforeNext(' ')->build()
    ->upper()->patch();  // HELLO World!
```

#### <a name="reference-strings-prepend"></a> prepend($string): StringInterface

Adds `$string` to the beginning of the current string.

```php
echo s('World!')->prepend('Hello ');  // 'Hello World!'
```

#### <a name="reference-strings-repeat"></a> repeat($multiplier = 2): StringInterface

Returns the string repeated `$multiplier` times.

```php
echo s('+-')->repeat(5);  // +-+-+-+-+-
```

#### <a name="reference-strings-repeat-to-size"></a> repeatToSize($size): StringInterface

Repeats the string up to the given size.

```php
echo s('+-')->repeatToSize(15);  // +-+-+-+-+-+-+-+
```

#### <a name="reference-strings-replace"></a> replace($string): StringInterface

Replaces the current string with `$string`.

```php
echo s('Hello')->replace('Good Morning');  // Good Morning
```

#### <a name="reference-strings-replace-all"></a> replaceAll($search, $replace): StringInterface

Replaces all occurrences of the `$search` string(s) with the `$replace` string(s).
Works in the same way as PHP function `str_replace`.

```php
echo s('Hello World')->replaceAll(['o', 'l'], '*');  // He*** W*r*d
```

#### <a name="reference-strings-reverse"></a> reverse()

Reverses the characters of the string.

```php
echo s('Hello World!')->reverse();  // !dlroW olleH
```

#### <a name="reference-strings-select"></a> select($offset = 0): SubstringBuilder

Starts the selection of a substring, beginning at the given `$offset`.

#### <a name="reference-strings-separate"></a> separate($delimiters): SubstringListInterface

Splits the string by multiple delimiters.

```php
echo s('123 456,789')->separate([' ', ','])->reverse()->patch();  // 321 654,987
```

#### <a name="reference-strings-shuffle"></a> shuffle(): StringInterface

Randomly shuffles the string.

```php
echo s('Hello World!')->shuffle();  // rloodl!He lW
```

#### <a name="reference-strings-split"></a> split($size = 1): SubstringListInterface

Splits the string in substrings of `$size` characters.

```php
echo s('Hello World!')->split(3)->implode('|');  // Hel|lo |Wor|ld!
```

#### <a name="reference-strings-squeeze"></a> squeeze($char = ' '): StringInterface

Replaces consecutive occurences of `$char` with one character only.

```php
echo s('Hello    World!')->squeeze();  // Hello World!
```

#### <a name="reference-strings-starts-with"></a> startsWith($substring): bool

Determines if the string starts with `$substring`.

```php
echo s('Hello World!')->startsWith('Hello') ? 'true' : 'false';  // true
echo s('Hello World!')->startsWith('World!') ? 'true' : 'false'; // false
```

#### <a name="reference-strings-starts-with-any"></a> startsWithAny($substrings): bool

Determines if the string starts with any of the strings in `$substrings`.

```php
echo s('Hello World!')->startsWithAny(['Everybody!', 'World!']) ? 'true' : 'false';  // true
```

#### <a name="reference-strings-surround-with"></a> surroundWith($string1, $string2 = null): StringInterface

Adds `$string1` to the beginning of the string and `$string2` (or `$string1` is `$string2` is `null`) to the end.

```php
echo s('Hello World!')->surroundWith('"', '"');  // "Hello World!"
```

#### <a name="reference-strings-titleize"></a> titleize(): StringInterface

Converts first word of each word to uppercase, and the others to lowercase.

```php
echo s('hELLO world!')->titleize();  // Hello World!
```

#### <a name="reference-strings-to-string"></a> toString(): string

Converts the string to an ordinary string.

```php
echo s('Hello World!')->toString();  // Hello World!
```

#### <a name="reference-strings-to-binary"></a> toBinary(): BinarfyStringInterface

*Available for Unicode strings only.*

Converts an Unicode string to a binary string.

```php
$str = u('Доброе утро.');
echo $str->length();              // 12
echo $str->toBinary()->length();  // 22
```

#### <a name="reference-stringsto-case-sensitive-"></a> toCaseSensitive(): CaseSensitiveInterface

*Available for case insensitive strings only.*

Converts a case insensitive string to a case sensitive string.

```php
$str = u('Hello World!')->toCaseInsensitive();
echo $str->startsWith('hello') ? 'true' : 'false';                     // true
echo $str->toCaseSensitive()->startsWith('hello') ? 'true' : 'false';  // false
```


#### <a name="reference-strings-to-case-insensitive"></a> toCaseInsensitive(): CaseInsensitiveInterface

*Available for case sensitive strings only.*

Converts a case sensitive string to a case insensitive string.

```php
$str = u('Hello World!');
echo $str->startsWith('hello') ? 'true' : 'false';                       // false
echo $str->toCaseInsensitive()->startsWith('hello') ? 'true' : 'false';  // true
```

#### <a name="reference-strings-to-encoding"></a> toEncoding($encoding): UnicodeStringInterface

*Available for Unicode strings only.*

Modifies the encoding of the string.

```php
echo u('«Hello World!»')->toEncoding('HTML');  // &laquo;Hello World!&raquo;
```

#### <a name="reference-strings-to-unicode"></a> toUnicode($encoding = 'UTF-8'): UnicodeStringInterface

*Available for binary strings only.*

Converts a binary string to an Unicode string with the specified `$encoding`.

```php
$str = s('Доброе утро.');
echo $str->length();               // 22
echo $str->toUnicode()->length();  // 12
```

#### <a name="reference-strings-transform"></a> transform($callable): StringInterface

Applies a custom tranformation to the string.
The result must have the same type as the current string.
If it is not true, it is converted.

```php
echo s('Hello World')->transform(function ($s) {
    return md5($s);
})->upper();  //  B10A8DB164E0754105B7A99BE72E3FE5
```

#### <a name="reference-strings-trim"></a> trim($charlist = null): StringInterface

Strips whitespaces or characters in `$charlist` if not `null` from both the beginning an the end of the string.

```php
echo s('***Hello World!***')->trim('*');  // Hello World!
```

#### <a name="reference-strings-trim-left"></a> trimLeft($charlist = null): StringInterface

Strips whitespaces or characters in `$charlist` if not `null` from the beginning of the string.

```php
echo s('***Hello World!***')->trimLeft('*');  // Hello World!***
```

#### <a name="reference-strings-trim-right"></a> trimRight($charlist = null): StringInterface

Strips whitespaces or characters in `$charlist` if not `null` from the end of the string.

```php
echo s('***Hello World!***')->trimRight('*');  // ***Hello World!
```

#### <a name="reference-strings-truncate"></a> truncate($size, $string = ''): StringInterface

Truncates on the right to `$size` characters. If `$string` is not empty, 
deleted characters are replaced with it (additional characters are remove
so that the length of the string does not exceed the given size).

```php
echo s('Hello World!')->truncate(8, '...'); // Hello...
```

#### <a name="reference-stringstruncate-left-"></a> truncateLeft($size, $string = ''): StringInterface

Truncates on the left to `$size` characters. If `$string` is not empty, 
deleted characters are replaced with it (additional characters are remove
so that the length of the string does not exceed the given size).

```php
echo s('Hello World!')->truncateLeft(8, '...'); // ...orld!
```

#### <a name="reference-strings-truncate-middle"></a> truncateMiddle($size, $string = ''): StringInterface

Truncates on the middle to `$size` characters. If `$string` is not empty, 
deleted characters are replaced with it (additional characters are remove
so that the length of the string does not exceed the given size).

```php
echo s('Hello World!')->truncateMiddle(8, '...'); // He...ld!
```

#### <a name="reference-strings-upper"></a> upper(): StringInterface

Converts the string to uppercase.

```php
echo s("hello")->lower();  // HELLO
```

#### <a name="reference-strings-upper-first"></a> upperFirst(): StringInterface

Converts the first character of the string to upppercase.

```php
echo s("hello")->lower();  // Hello
```

### <a name="reference-substring-builder"></a> Substring builder

To create a substring builder, use the `select` method on the string.
The methods of the substring builder allow you to set a start index and a end index for the substring.

Note that:
- The end index correspond to the index of the first excluded character.
- If you provide an offset to the `select` method, indices are numbered from this offset. 
For example if the offset is 5, an index of 2 in the substring builder corresponds to an index of 7 in the string. 

#### <a name="reference-substring-builder-after"></a> after($index): SubstringBuilderInterface

Moves the start index just after the index `$index`.

```php
echo s('foo,bar')->select()->after(3);  // bar
```

#### <a name="reference-substring-builder-after-first"></a> afterFirst($substring): SubstringBuilderInterface

Moves the start index just after the last character of the first occurence of `$substring`.

```php
echo s('foo,bar,foo,baz')->select()->afterFirst('foo');  // ,bar,foo,baz
```

#### <a name="reference-substring-builder-after-last"></a> afterLast($substring): SubstringBuilderInterface

Moves the start index just after the last character of the last occurence of `$substring`.

```php
echo s('foo,bar,foo,baz')->select()->afterLast('foo');  // ,baz
```

#### <a name="reference-substring-builder-at"></a> at($index): SubstringBuilderInterface

Moves the start index and the end index to the index `$index`. 
The selection is empty. 
Useful to insert a string at a specific position.

```php
echo s('foo,bar')->select()->at(3)->patch(',baz');  // foo,baz,bar
```

#### <a name="reference-substring-builder-at-end-of-first"></a> atEndOfFirst($substring): SubstringBuilderInterface

Moves the start index and the end index just after the last character of the first occurence of `$substring`. 
The selection is empty. 
Useful to insert a string after a specific substring.

```php
echo s('foo,bar,foo')->select()->atEndOfFirst('foo')->patch(',baz');  // foo,baz,bar,foo
```

#### <a name="reference-substring-builder-at-end-of-last"></a> atEndOfLast($substring): SubstringBuilderInterface

Moves the start index and the end index just after the last character of the last occurence of `$substring`. 
The selection is empty. 
Useful to insert a string after a specific substring.

```php
echo s('foo,bar,foo')->select()->atEndOfLast('foo')->patch(',baz');  // foo,bar,foo,baz
```

#### <a name="reference-substring-builder-at-start-of-first"></a> atStartOfFirst($substring): SubstringBuilderInterface

Moves the start index and the end index at the first character of the first occurence of `$substring`. 
The selection is empty. 
Useful to insert a string before a specific substring.

```php
echo s('foo,bar,foo')->select()->atStartOfFirst('foo')->patch('baz,');  // baz,foo,bar,foo
```

#### <a name="reference-substring-builder-at-start-of-last"></a> atStartOfLast($substring): SubstringBuilderInterface

Moves the start index and the end index at the first character of the last occurence of `$substring`. 
The selection is empty. 
Useful to insert a string before a specific substring.

```php
echo s('foo,bar,foo')->select()->atStartOfLast('foo')->patch('baz,');  // foo,bar,baz,foo
```

#### <a name="reference-substring-builder-before"></a> before($index): SubstringBuilderInterface

Moves the end index to the specified index.

```php
echo s('foo,bar')->select()->before(3);  // foo
```

#### <a name="reference-substring-builder-before-last"></a> beforeLast($substring): SubstringBuilderInterface

Moves the end index to the first char of the last occurence of `$substring`.

```php
echo s('foo,bar,foo')->select()->beforeLast('foo');  // foo,bar,
```

#### <a name="reference-substring-builder-before-next"></a> beforeNext($substring, $includeStart = false): SubstringBuilderInterface

Moves the end index to the first char of the first occurence of `$substring` from the current start index.
If `$includeStart` is `true`, the search start at the start index. Otherwise, the search starts at the next character.

```php
echo s('foo,bar,foo,bar')->select()->beforeNext('bar');        // foo,
echo s('foo,bar,foo,bar')->select()->beforeNext('foo');        // foo,bar,
echo s('foo,bar,foo,bar')->select()->beforeNext('foo', true);  // <empty string>
```

#### <a name="reference-substring-builder-between-substrings"></a> betweenSubstrings($open, $close, $match = false): SubstringBuilderInterface

If `$match` is false, moves the start index and the end index so they select the first susbtring beginning
with `$open` and finishing with `$close`.

If `$match` is true, moves the start index and the end index so they select the first susbtring beginning
with `$open` and finishing with `$close` matching `$open`.

```php
echo s('foo,(bar,(foo),bar')->select()->betweenSubstrings('(', ')', true);  // (foo)
echo s('foo,(bar,(foo),bar')->select()->betweenSubstrings('(', ')');        // (bar,(foo)
```

#### <a name="reference-substring-builder-build"></a> build(): StringInterface

Creates a `StringInterface` from the selection.

```php
echo s('foo,bar,baz')->select()->first('bar')->build()->upper();  // BAR
```

#### <a name="reference-substring-builder-end"></a> end(): int

Returns the end index of the selection.

```php
echo s('foo,bar,baz')->select()->first('bar')->end();  // 7
```

#### <a name="reference-substring-builder-first"></a> first($substring): SubstringBuilderInterface

Selects the first occurrence of `$substring`.

```php
echo s('foo,bar,foo,bar')->select()->first('bar')->patch('***');  // foo,***,foo,bar
```

#### <a name="reference-substring-builder-from"></a> from($index): SubstringBuilderInterface

Moves the start index to `$index`.

```php
echo s('foo,bar')->select()->from(3);  // ,bar
```

#### <a name="reference-substring-builder-from-first"></a> fromFirst($substring): SubstringBuilderInterface

Move the start index to the first character of the first occurence of `$substring`.

```php
echo s('foo,bar,baz')->select()->fromFirst(',');  // ,bar,baz
```

#### <a name="reference-substring-builder-from-last"></a> fromLast($substring): SubstringBuilderInterface

Moves the start index to the first character of the last occurence of `$substring`.

```php
echo s('foo,bar,baz')->select()->fromLast(',');  // ,baz
```

#### <a name="reference-substring-builder-from-left"></a> fromLeft(): SubstringBuilderInterface

Moves the start index to the beginning of the string.

```php
echo s('foo,bar')->select()->from(3)->fromLeft();  // foo,bar
```

#### <a name="reference-substring-builder-from-length"></a> fromLength($length): SubstringBuilderInterface

Moves the start index so that the selection length is `$length`.

```php
echo s('foo,bar,baz')->select()->beforeLast(',')->fromLength(3);  // bar
```

#### <a name="reference-substring-builder-grow"></a> grow($count): SubstringBuilderInterface

Expands the current selection by `$count` characters on each side.

```php
echo s('foo,bar,baz')->select()->afterFirst(',')->beforeNext(',')->grow(1);  // ,bar,
```

#### <a name="reference-substring-builder-inside-substrings"></a> insideSubstrings($open, $close, $match = false): SubstringBuilderInterface

If `$match` is false, moves the start index and the end index so they select the first susbtring preceded
by `$open` and followed by `$close`.

If `$match` is true, moves the start index and the end index so they select the first susbtring preceded
by `$open` and followed by `$close` matching `$open`.

```php
echo s('foo,(bar,(foo),bar')->select()->insideSubstrings('(', ')', true);  // foo
echo s('foo,(bar,(foo),bar')->select()->insideSubstrings('(', ')');        // bar,(foo
```

#### <a name="reference-substring-builder-is-empty"></a> isEmpty(): bool

Determines if the current selection is empty.

```php
echo s('foo,bar')->select()->first('baz')->isEmpty() ? 'true' : 'false';  // true
echo s('foo,bar')->select()->from(10)->to(15)->isEmpty() ? 'true' : 'false';       // true
echo s('foo,bar')->select()->from(3)->to(5)->isEmpty() ? 'true' : 'false';         // false
```

#### <a name="reference-substring-builder-last"></a> last($substring): SubstringBuilderInterface

Selects the last occurrence of `$substring`.

```php
echo s('foo,bar,foo,bar')->select()->last('bar')->patch('***');  //  foo,bar,foo,***
```

#### <a name="reference-substring-builder-length"></a> length(): int

Returns the length of the selection.

```php
echo s('foo,bar,baz')->select()->first('bar')->length();  // 3
```

#### <a name="reference-substring-builder-longest-common-prefix"></a> longestCommonPrefix($string): SubstringBuilderInterface

Selects the longest string common to the current string and `$string`, starting from the beginning of each string.

```php
echo s('foo,bar,baz')->select()->longestCommonPrefix('foo,baz,bar');  // foo,ba
```

#### <a name="reference-substring-builder-longest-common-substring"></a> longestCommonSubstring($string): SubstringBuilderInterface

Selects the longest string common to the current string and `$string`.

```php
echo s('foo,bar,baz')->select()->longestCommonSubstring('bar,baz,foo');  // bar,baz
```

#### <a name="reference-substring-builder-longest-common-suffix"></a> longestCommonSuffix($string): SubstringBuilderInterface

Selects the longest string common to the current string and `$string`, finishing at the end of each string.

```php
echo s('foo,bar,baz')->select()->longestCommonSuffix('bar,foo,baz');  // ,baz
```

#### <a name="reference-substring-builder-patch"></a> patch($patch): StringInterface

Returns a `StringInterface` with the selection replaced by `$patch`.

```php
echo s('foo,bar,baz')->select()->first('bar')->patch('***');  // foo,***,baz
```

#### <a name="reference-substring-builder-remove"></a> remove(): StringInterface

Returns a `StringInterface` with the selection removed.

```php
echo s('foo,bar,baz')->select()->first('bar')->remove('');  // foo,,baz
```

#### <a name="reference-substring-builder-select"></a> select($offset = 0): SubstringBuilderInterface

Start a new selection from the current selection. It is equivalent to do `build` followed by `select`.

```php
echo s('foo,bar,baz')->select()->afterFirst(',')->select()->afterFirst(',');  // baz
```

#### <a name="reference-substring-builder-selection"></a> selection(): array | null

If the selection is valid, returns an array containing the start index and the end index in this order.
If the selection is invalid (for example if you try to select a substring which does not exist), returns `null`.

```php
$selection = s('foo,bar,baz')->select()->first('bar')->selection();  // $selection = [4, 7] 
```

#### <a name="reference-substring-builder-shift-left"></a> shiftLeft($count): SubstringBuilderInterface

Shifts the start index from `$count` characters. `$count` can be negative.

```php
echo s('foo,bar,baz')->select()->from(5)->start();                 // 5
echo s('foo,bar,baz')->select()->from(5)->shiftLeft(1)->start();   // 6
echo s('foo,bar,baz')->select()->from(5)->shiftLeft(-1)->start();  // 4
```

#### <a name="reference-substring-builder-shift-right"></a> shiftRight($count): SubstringBuilderInterface

Shifts the end index from `$count` characters. `$count` can be negative.

```php
echo s('foo,bar,baz')->select()->to(5)->end();                  // 6
echo s('foo,bar,baz')->select()->to(5)->shiftRight(1)->end();   // 7
echo s('foo,bar,baz')->select()->to(5)->shiftRight(-1)->end();  // 5
```

#### <a name="reference-substring-builder-shrink"></a> shrink($count): SubstringBuilderInterface

Shrinks the current selection by `$count` characters on each side.

```php
echo s('foo,bar,baz')->select()->fromFirst(',')->toNext(',')->shrink(1);  // bar
```

#### <a name="reference-substring-builder-start"></a> start(): int

Return the current start index.

```php
echo s('foo,bar,baz')->select()->first('bar')->start();  // 4
```

#### <a name="reference-substring-builder-to"></a> to($index): SubstringBuilderInterface

Moves the end index just after the character at index `$index`.

```php
echo s('foo,bar')->select()->to(3);  // foo,
```

#### <a name="reference-substring-builder-to-last"></a> toLast($substring): SubstringBuilderInterface

Moves the end index just after the last character of the last occurrence of `$substring`.

```php
echo s('foo,bar,baz')->select()->toLast(',');  // foo,bar,
```

#### <a name="reference-substring-builder-to-length"></a> toLength($length): SubstringBuilderInterface

Moves the end index so that the selection length is `$length`.

```php
echo s('foo,bar,baz')->select()->afterFirst(',')->toLength(3);  // bar
```

#### <a name="reference-substring-builder-to-next"></a> toNext($substring, $includeStart = false): SubstringBuilderInterface

Moves the end index just after the last character of the first occurrence of `$substring` from the start index.
If `$includeStart` is `true`, the search start at the start index. Otherwise, the search starts at the next character.

```php
echo s('foo,bar,foo,bar')->select()->toNext('bar');        // foo,bar
echo s('foo,bar,foo,bar')->select()->toNext('foo');        // foo,bar,foo
echo s('foo,bar,foo,bar')->select()->toNext('foo', true);  // foo
```

#### <a name="reference-substring-builder-to-right"></a> toRight($substring): SubstringBuilderInterface

Moves the end index to the end of the string.

```php
echo s('foo,bar')->select()->to(3)->toRight();  // foo,bar
```

#### <a name="reference-substring-builder-to-string"></a> toString(): string

Return the selected substring as an ordinary string.

```php
echo s('foo,bar,baz')->select()->from(4)->to(6)->toString();  // bar
```

### <a name="reference-substring-list"></a> Substring Lists

Classes `CaseSensitiveBinarySubstringList`, `CaseInsensitiveBinarySubstringList`, 
`CaseSensitiveUnicodeSubstringList`, `CaseInsensitiveUnicodeSubstringList` implements the same methods as the corresponding
`StringInterface`.

This section describes additional methods and methods with an altered behavior.

#### <a name="reference-substring-list-after-substring-at"></a> afterSubstringAt($index): StringInterface

Returns the string just after the substring at index `$index` (and before the next substring).

```php
echo s('foo,bar;baz')->separate([',', ';'])->afterSubstringAt(0);  // ,
echo s('foo,bar;baz')->separate([',', ';'])->afterSubstringAt(1);  // ;
echo s('foo,bar;baz')->separate([',', ';'])->afterSubstringAt(2);  // <empty string>
```

#### <a name="reference-substring-list-before-substring-at"></a> beforeSubstringAt($index): StringInterface

Returns the string just before the substring at index `$index` (and after the previous substring).

```php
echo s('foo,bar;baz')->separate([',', ';'])->beforeSubstringAt(0);  // <empty string>
echo s('foo,bar;baz')->separate([',', ';'])->beforeSubstringAt(1);  // ,
echo s('foo,bar;baz')->separate([',', ';'])->beforeSubstringAt(2);  // ;
```

#### <a name="reference-substring-list-convert"></a> convert($callable): array

Same as [convert](#reference-strings-convert), but `$callable` accepts a second argument containing information
about the current substring. This additional argument is an instance of `SubstringInfo`.

```php
$lengths = s('foo,bar;baz')->separate([',', ';'])->convert(function ($s, $info) {
    return $info->length();
});   // $lengths = [3, 3, 3]
```

#### <a name="reference-substring-list-count"></a> count(): int

Returns the number of substrings. You can also use the PHP function `count`.

```php
echo s('foo,bar;baz')->separate([',', ';'])->count();  // 3
echo count(s('foo,bar;baz')->separate([',', ';']));    // 3
```

#### <a name="reference-substring-list-end"></a> end(): array

Returns indices of the character following each substring.

```php
$result = s('foo,bar;baz')->separate([',', ';'])->end();  // $result = [3, 7, 11]
```

#### <a name="reference-substring-list-get-string"></a> getString(): StringInterface

Returns the original string.

```php
echo s('foo,bar;baz')->separate([',', ';'])->getString();  // foo,bar;baz
```

#### <a name="reference-substring-list-implode"></a> implode($separator): StringInterface

Join substrings with `$separator`.

```php
echo s('foo,bar;baz')->separate([',', ';'])->implode('.');  // foo.bar.baz
```

#### <a name="reference-substring-list-info"></a> info($template = null): array

Returns information about each substring. If `$template` is `null`, the returned array contains instances of
`SubstringInfo`. If you provide a template, the returned array items are build according to the template.

```php
$info = s('foo,bar;baz')
    ->separate([',', ';'])
    ->info(['start' => SubstringListInterface::INFO_START, 'end' => SubstringListInterface::INFO_END]);
// $info = [['start' => 0, 'end' => 3], ['start' => 4, 'end' => 7], ['start' => 8, 'end' => 11]]
```

#### <a name="reference-substring-list-patch"></a> patch(): StringInterface

Applies substrings changes to the original string.

```php
echo s('foo,bar;baz')->separate([',', ';'])->reverse()->patch();  // oof,rab;zab
```

#### <a name="reference-substring-list-remove"></a> remove(): StringInterface

Remove substrings from the original string.

```php
echo s('foo,bar;baz')->separate([',', ';'])->remove();  // ,;
```

#### <a name="reference-substring-list-start"></a> start(): array

Returns indices of the first character of each substring.

```php
$result = s('foo,bar;baz')->separate([',', ';'])->start();  // $result = [0, 4, 8]
```

#### <a name="reference-substring-list-substring-at"></a> substringAt($index): StringInterface

Returns the substring at index `$index`.

```php
echo s('foo,bar;baz')->separate([',', ';'])->substringAt(1);  // bar
```

#### <a name="reference-substring-list-to-array"></a> toArray(): array

Returns an array of substrings.

#### <a name="reference-substring-list-transform"></a> transform($callable): SubstringListInterface

Same as [transform](#reference-strings-transform), but `$callable` accepts a second argument containing information
about the current substring. This additional argument is an instance of `SubstringInfo`.

```php
echo s('foo,bar;baz')->separate([',', ';'])->transform(function ($s, $info) {
    return $info->index() . ': ' . $s;
})->implode(', ');   // 0: foo, 1: bar, 2: baz
```

