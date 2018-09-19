<?php

use LucLeroy\Strings\CaseInsensitiveUnicodeString;
use LucLeroy\Strings\CaseSensitiveUnicodeString;
use LucLeroy\Strings\SubstringBuilder\CaseInsensitiveUnicodeSubstringBuilder;
use LucLeroy\Strings\SubstringList\SubstringListInterface;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/BasicCaseTransformer.php';

defined('NOT_PROVIDED') || define('NOT_PROVIDED', uniqid());

class CaseInsensitiveUnicodeStringTest extends TestCase
{

    /**
     * @dataProvider dataCreate
     */
    public function testCreate($string, $encoding, $expectedEncoding, $expected)
    {
        $result = $encoding === NOT_PROVIDED
            ? CaseInsensitiveUnicodeString::create($string)
            : CaseInsensitiveUnicodeString::create($string, $encoding);
        $this->assertInstanceOf(CaseInsensitiveUnicodeString::class, $result);
        $this->assertEquals($expectedEncoding, $result->getEncoding());
        $this->assertEquals($expected, $result->toString());
    }

    public function dataCreate()
    {
        return [
            ' 1. Default encoding' => ['àéîôù', NOT_PROVIDED, 'UTF-8', 'àéîôù'],
            ' 2. Default encoding' => ['&agrave;&eacute;&icirc;&ocirc;&ugrave;', 'HTML', 'HTML', '&agrave;&eacute;&icirc;&ocirc;&ugrave;'],
        ];
    }

    /**
     * @dataProvider dataStartsWith
     */
    public function testStartsWith($string, $substring, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->startsWith($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataStartsWith()
    {
        return [
            ' 1. Empty string'                                           => ['', 'àé', false],
            ' 2. Empty substring'                                        => ['àéîô', '', true],
            ' 3. Empty string and empty substring'                       => ['', '', true],
            ' 4. String starting with substring'                         => ['àéîô', 'àé', true],
            ' 5. String not starting with substring'                     => ['àéîô', 'éî', false],
            ' 6. String starting with substring but with different case' => ['àéîô', 'ÀÉ', true],
        ];
    }

    /**
     * @dataProvider dataStartsWithAny
     */
    public function testStartsWithAny($string, $substring, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->startsWithAny($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataStartsWithAny()
    {
        return [
            ' 1. String starting with no substrings'                    => ['àéîôùèçâ', ['îô', 'çâ', 'ùè'], false],
            ' 2. String starting with one substring'                    => ['àéîôùèçâ', ['îô', 'àé', 'ùè'], true],
            ' 3. String starting with one substring, but not same case' => ['àéîôùèçâ', ['îô', 'ÀÉ', 'ùè'], true],
        ];
    }

    /**
     * @dataProvider dataEndsWithAny
     */
    public function testEndsWithAny($string, $substring, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->endsWithAny($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataEndsWithAny()
    {
        return [
            ' 1. String ending with no substrings'                    => ['àéîôùèçâ', ['ôù', 'àé', 'éî'], false],
            ' 2. String ending with one substring'                    => ['àéîôùèçâ', ['ôù', 'çâ', 'éî'], true],
            ' 3. String ending with one substring, but not same case' => ['àéîôùèçâ', ['ôù', 'ÇÂ', 'éî'], true],
        ];
    }

    /**
     * @dataProvider dataEndsWith
     */
    public function testEndsWith($string, $substring, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->endsWith($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataEndsWith()
    {
        return [
            ' 1. Empty string'                                         => ['', 'àé', false],
            ' 2. Empty substring'                                      => ['àéîô', '', true],
            ' 3. Empty string and empty substring'                     => ['', '', true],
            ' 4. String ending with substring'                         => ['àéîô', 'îô', true],
            ' 5. String not ending with substring'                     => ['àéîô', 'éî', false],
            ' 6. String ending with substring but with different case' => ['àéîô', 'ÎÔ', true],
        ];
    }

    /**
     * @dataProvider dataEnsureLeft
     */
    public function testEnsureLeftStart($string, $substring, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->ensureLeft($substring)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataEnsureLeft()
    {
        return [
            ' 1. String starting with substring'                     => ['àéîôù', 'àé', 'àéîôù'],
            ' 2. String starting with substring, but different case' => ['àéîôù', 'ÀÉ', 'àéîôù'],
            ' 3. String not starting with substring'                 => ['îôù', 'àé', 'àéîôù'],
        ];
    }

    /**
     * @dataProvider dataEnsureRight
     */
    public function testEnsureRight($string, $substring, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->ensureRight($substring)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataEnsureRight()
    {
        return [
            ' 1. String ending with substring'                     => ['àéîôù', 'ôù', 'àéîôù'],
            ' 2. String ending with substring, but different case' => ['àéîôù', 'ÔÙ', 'àéîôù'],
            ' 3. String not ending with substring'                 => ['àéîôù', 'îô', 'àéîôùîô'],
        ];
    }

    /**
     * @dataProvider dataReplaceAll
     */
    public function testReplaceAll($string, $search, $replace, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->replaceAll($search, $replace)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataReplaceAll()
    {
        return [
            ' 1. Replace one string'                              => ['abôcdñéfÑgh', 'ñ', '*', 'abôcd*éf*gh'],
            ' 2. Replace multiple strings with same string'       => ['abôcdñéfÑgh', ['ô', 'ñ'], '*', 'ab*cd*éf*gh'],
            ' 3. Replace multiple strings with different strings' => ['abôcdñéfÑgh', ['ô', 'ñ'], ['*', '-'], 'ab*cd-éf-gh'],
        ];
    }

    /**
     * @dataProvider dataContains
     */
    public function testContains($string, $substring, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->contains($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataContains()
    {
        return [
            ' 1. String containing substring'     => ['àéîôù', 'éî', true],
            ' 2. String not containing substring' => ['àéîôù', 'îé', false],
        ];
    }

    /**
     * @dataProvider dataContainsAny
     */
    public function testContainsAny($string, $substrings, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->containsAny($substrings);
        $this->assertEquals($expected, $result);
    }

    public function dataContainsAny()
    {
        return [
            ' 1. String containing no substrings'                    => ['àéîôùèçâñ', ['àéè', 'îôè', 'âñè'], false],
            ' 2. String containing one substring'                    => ['àéîôùèçâñ', ['àéè', 'ôùè', 'âñè'], true],
            ' 3. String containing one substring, but not same case' => ['àéîôùèçâñ', ['àéè', 'ÔÙÈ', 'âñè'], true],
        ];
    }

    /**
     * @dataProvider dataContainsAll
     */
    public function testContainsAll($string, $substrings, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->containsAll($substrings);
        $this->assertEquals($expected, $result);
    }

    public function dataContainsAll()
    {
        return [
            ' 1. String containing no substrings'                     => ['àéîôùèçâñ', ['àéè', 'îôè', 'âñè'], false],
            ' 2. String containing one substring, but not all'        => ['àéîôùèçâñ', ['àéè', 'ôùè', 'âñè'], false],
            ' 3. String containing all substrings'                    => ['àéîôùèçâñ', ['àéî', 'ôùè', 'çâñ'], true],
            ' 4. String containing all substrings, but not same case' => ['àéîôùèçâñ', ['àéî', 'ÔÙÈ', 'çâñ'], true],
        ];
    }

    /**
     * @dataProvider dataIsSubstringOf
     */
    public function testIsSubstringOf($string, $anotherString, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->isSubstringOf($anotherString);
        $this->assertEquals($expected, $result);
    }

    public function dataIsSubstringOf()
    {
        return [
            ' 1. Is not substring'                => ['ùèù', 'àéîôùèçâñ', false],
            ' 2. Is substring'                    => ['ôùè', 'àéîôùèçâñ', true],
            ' 3. Is substring, but not same case' => ['ÔÙÈ', 'àéîôùèçâñ', true],
        ];
    }

    /**
     * @dataProvider dataIsSubstringOfAny
     */
    public function testIsSubstringOfAny($string, $strings, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->isSubstringOfAny($strings);
        $this->assertEquals($expected, $result);
    }

    public function dataIsSubstringOfAny()
    {
        return [
            ' 1. Is substring of no strings'                    => ['ôùè', ['àéîôùçâñ', 'àéçâñ', 'àùèçâñ'], false],
            ' 2. Is substring of one string'                    => ['ôùè', ['àéîôùçâñ', 'àéôùèçâñ', 'àùèçâñ'], true],
            ' 3. Is substring of one string, but not same case' => ['ôùè', ['àéîôùçâñ', 'àéçÔÙÈâñ', 'àùèçâñ'], true],
        ];
    }

    /**
     * @dataProvider dataIsSubstringOfAll
     */
    public function testIsSubstringOfAll($string, $strings, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->isSubstringOfAll($strings);
        $this->assertEquals($expected, $result);
    }

    public function dataIsSubstringOfAll()
    {
        return [
            ' 1. Is substring of no strings'                     => ['ôùè', ['àéîôùçâñ', 'àéçâñ', 'àùèçâñ'], false],
            ' 2. Is substring of one string'                     => ['ôùè', ['àéîôùçâñ', 'àéçôùèâñ', 'àùèçâñ'], false],
            ' 3. Is substring of all strings'                    => ['ôùè', ['àéîôùèçâñ', 'àéçâñôùè', 'ôùèàùèçâñ'], true],
            ' 4. Is substring of all strings, but not same case' => ['ôùè', ['àéîÔÙÈçâñ', 'àéçâñôùè', 'ôùèàùèçâñ'], true],
        ];
    }

    /**
     * @dataProvider dataIs
     */
    public function testIs($string, $otherString, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->is($otherString);
        $this->assertEquals($expected, $result);
    }

    public function dataIs()
    {
        return [
            ' 1. Same strings'                    => ['àéîÔÙÈçâñ', 'àéîÔÙÈçâñ', true],
            ' 2. Same strings but incorrect case' => ['àéîÔÙÈçâñ', 'àéîôùèçâñ', true],
        ];
    }

    /**
     * @dataProvider dataIsAny
     */
    public function testIsAny($string, $otherString, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->isAny($otherString);
        $this->assertEquals($expected, $result);
    }

    public function dataIsany()
    {
        return [
            ' 1. Empty array of strings'             => ['àéîôù', [], false],
            ' 2. String in array'                    => ['àéîôù', ['èçâñ', 'àéîôù', 'àéîñ'], true],
            ' 3. String in array but incorrect case' => ['àéîôù', ['èçâñ', 'àéîÔÙ', 'àéîñ'], true],
            ' 4. String not in array'                => ['àéîôù', ['èçâñ', 'îôùèç', 'àéîñ'], false],
        ];
    }

    /**
     * @dataProvider dataCountOf
     */
    public function testCountOf($string, $substring, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->countOf($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataCountOf()
    {
        return [
            ' 1. String containing the substring'                     => ['àéîôùèîôñ', 'îô', 2],
            ' 2. String containing the substring with different case' => ['àéîôùèÎÔñ', 'îô', 2],
        ];
    }

    /**
     * @dataProvider dataTransform
     */
    public function testTransform($string, $callable, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->transform($callable);
        $this->assertInstanceOf(CaseInsensitiveUnicodeString::class, $result);
        $this->assertEquals($expected, $result->toString());
    }

    public function dataTransform()
    {
        return [
            ' 1. Result is a string' => ['àéîô', function($s) {
                    return $s->reverse();
                }, 'ôîéà'],
            ' 2. Result is an integer' => ['àéîô', function($s) {
                    return $s->length();
                }, '4'],
        ];
    }

    /**
     * @dataProvider dataExplode
     */
    public function testExplode($string, $delimiter, $limit, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->explode($delimiter, $limit)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataExplode()
    {
        return [
            ' 1. No limit'   => ['abôcdôéfÔgh', 'ô', PHP_INT_MAX, ['ab', 'cd', 'éf', 'gh']],
            ' 2. With limit' => ['abôcdÔéfÔgh', 'ô', 3, ['ab', 'cd', 'éfÔgh']],
        ];
    }

    /**
     * @dataProvider dataOccurences
     */
    public function testOccurences($string, $substrings, $expected)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->occurences($substrings)
            ->info([SubstringListInterface::INFO_START, SubstringListInterface::INFO_END]);
        $this->assertEquals($expected, $result);
    }

    public function dataOccurences()
    {
        return [
            ' 1. One substring with no occurences'              => ['àéîôùèÎÔù', 'ab', []],
            ' 2. One substring with occurences'                 => ['àéîôùèÎôù', 'ôù', [[3, 5], [7, 9]]],
            ' 3. One substring with occurences, different case' => ['àéîôùèÎÔù', 'ôù', [[3, 5], [7, 9]]],
        ];
    }

    /**
     * @dataProvider dataSeparate
     */
    public function testSeparate($string, $delimiters, $expectedSubstrings, $expectedRest)
    {
        $result = CaseInsensitiveUnicodeString::create($string)
            ->separate($delimiters);
        $this->assertEquals($expectedSubstrings, $result->toArray());
        $this->assertEquals($expectedRest, $result->replace('*')->patch()->toString());
    }

    public function dataSeparate()
    {
        return [
            ' 1. Multiple delimiters' => ['1ô2é3Ô4', ['ô', 'é'], ['1', '2', '3','4'], '*ô*é*Ô*'],
        ];
    }

    public function testToCaseSensitive()
    {
        $result = CaseInsensitiveUnicodeString::create('àéî')
            ->toCaseSensitive();
        $this->assertInstanceOf(CaseSensitiveUnicodeString::class, $result);
        $this->assertEquals('àéî', $result->toString());
    }

    public function testSelect()
    {
        $result = CaseInsensitiveUnicodeString::create('abc')
            ->select();
        $this->assertInstanceOf(CaseInsensitiveUnicodeSubstringBuilder::class, $result);
    }

}
