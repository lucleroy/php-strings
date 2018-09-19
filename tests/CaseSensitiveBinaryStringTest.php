<?php

use LucLeroy\Strings\CaseInsensitiveBinaryString;
use LucLeroy\Strings\CaseSensitiveBinaryString;
use LucLeroy\Strings\SubstringBuilder\CaseSensitiveBinarySubstringBuilder;
use LucLeroy\Strings\SubstringList\SubstringListInterface;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/BasicCaseTransformer.php';

defined('NOT_PROVIDED') || define('NOT_PROVIDED', uniqid());

class CaseSensitiveBinaryStringTest extends TestCase
{

    public function testCreate()
    {
        $this->assertInstanceOf(CaseSensitiveBinaryString::class, CaseSensitiveBinaryString::create('abcd'));
        $this->assertEquals('abcd', CaseSensitiveBinaryString::create('abcd')->toString());
    }

    public function test_ToString()
    {
        $this->assertEquals('abcd', CaseSensitiveBinaryString::create('abcd') . '');
    }

    /**
     * 
     * @dataProvider dataChars
     */
    public function testChars($string, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->chars();
        $this->assertEquals($expected, $result);
    }

    public function dataChars()
    {
        return [
            ' 1. Empty string'     => ['', []],
            ' 2. Non empty string' => ['abc', ['a', 'b', 'c']],
        ];
    }

    /**
     * 
     * @dataProvider dataClear
     */
    public function testClear($string)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->clear()
            ->toString();
        $this->assertEquals('', $result);
    }

    public function dataClear()
    {
        return [
            ' 1. Empty string'     => [''],
            ' 2. Non empty string' => ['abc'],
        ];
    }

    /**
     * @dataProvider dataLength
     */
    public function testLength($string, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->length();
        $this->assertEquals($expected, $result);
    }

    public function dataLength()
    {
        return [
            ' 1. Empty string'     => ['', 0],
            ' 2. Non empty string' => ['abc', 3],
        ];
    }

    /**
     * @dataProvider dataIsEmpty
     */
    public function testIsEmpty($string, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->isEmpty();
        $this->assertEquals($expected, $result);
    }

    public function dataIsEmpty()
    {
        return [
            ' 1. Empty string'     => ['', true],
            ' 2. Non empty string' => ['abc', false],
        ];
    }

    /**
     * @dataProvider dataAppend
     */
    public function testAppend($string, $stringToAppend, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->append($stringToAppend)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataAppend()
    {
        return [
            ' 1. Append an empty string to an empty string'       => ['', '', ''],
            ' 2. Append a non empty string to a non empty string' => ['ab', 'cd', 'abcd'],
            ' 3. Append an emptystring to a non empty string'     => ['ab', '', 'ab'],
            ' 4. Append a non empty string to an empty string'    => ['', 'ab', 'ab'],
        ];
    }

    /**
     * @dataProvider dataPrepend
     */
    public function testPrepend($string, $stringToPrepend, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->prepend($stringToPrepend)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataPrepend()
    {
        return [
            ' 1. Prepend an empty string to an empty string'       => ['', '', ''],
            ' 2. Prepend a non empty string to a non empty string' => ['ab', 'cd', 'cdab'],
            ' 3. Prepend an empty string to a non empty string'    => ['ab', '', 'ab'],
            ' 4. Prepend a non empty string to an empty string'    => ['', 'ab', 'ab'],
        ];
    }

    /**
     * @dataProvider dataSurroundWith
     */
    public function testSurroundWith($string, $surroundLeft, $surroundRight, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string);
        $result = $result
            ->surroundWith($surroundLeft, $surroundRight)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataSurroundWith()
    {
        return [
            ' 1. Surround empty string with empty string'        => ['', '', null, ''],
            ' 2. Surround empty string with same char'           => ['', '*', null, '**'],
            ' 3. Surround empty string with different chars'     => ['', '(', ')', '()'],
            ' 4. Surround non empty string with empty string'    => ['ab', '', null, 'ab'],
            ' 5. Surround non empty string with same char'       => ['ab', '*', null, '*ab*'],
            ' 6. Surround non empty string with different chars' => ['ab', '(', ')', '(ab)'],
        ];
    }

    /**
     * @dataProvider dataRepeat
     */
    public function testRepeat($string, $multiplier, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string);
        $result = $result
            ->repeat($multiplier)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataRepeat()
    {
        return [
            ' 1. Repeat empty string, multiplier = 0'     => ['', 0, ''],
            ' 2. Repeat empty string, multiplier = 1'     => ['', 0, ''],
            ' 3. Repeat empty string, multiplier = 3'     => ['', 0, ''],
            ' 4. Repeat non empty string, multiplier = 0' => ['ab', 0, ''],
            ' 5. Repeat non empty string, multiplier = 1' => ['ab', 1, 'ab'],
            ' 6. Repeat non empty string, multiplier = 3' => ['ab', 3, 'ababab'],
        ];
    }

    /**
     * @dataProvider dataStartsWith
     */
    public function testStartsWith($string, $substring, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->startsWith($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataStartsWith()
    {
        return [
            ' 1. Empty string'                                           => ['', 'ab', false],
            ' 2. Empty substring'                                        => ['abcd', '', true],
            ' 3. Empty string and empty substring'                       => ['', '', true],
            ' 4. String starting with substring'                         => ['abcd', 'ab', true],
            ' 5. String not starting with substring, case sensitive'     => ['abcd', 'bc', false],
            ' 6. String starting with substring but with different case' => ['abcd', 'AB', false],
        ];
    }

    /**
     * @dataProvider dataStartsWithAny
     */
    public function testStartsWithAny($string, $substring, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->startsWithAny($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataStartsWithAny()
    {
        return [
            ' 1. String starting with no substrings'                    => ['abcdefgh', ['cd', 'de', 'fg'], false],
            ' 2. String starting with one substring'                    => ['abcdefgh', ['cd', 'de', 'ab'], true],
            ' 3. String starting with one substring, but not same case' => ['abcdefgh', ['cd', 'de', 'aB'], false],
        ];
    }

    /**
     * @dataProvider dataEndsWithAny
     */
    public function testEndsWithAny($string, $substring, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->endsWithAny($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataEndsWithAny()
    {
        return [
            ' 1. String ending with no substrings'                    => ['abcdefgh', ['cd', 'de', 'fg'], false],
            ' 2. String ending with one substring'                    => ['abcdefgh', ['cd', 'gh', 'fg'], true],
            ' 3. String ending with one substring, but not same case' => ['abcdefgh', ['cd', 'gH', 'fg'], false],
        ];
    }

    /**
     * @dataProvider dataEndsWith
     */
    public function testEndsWith($string, $substring, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->endsWith($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataEndsWith()
    {
        return [
            ' 1. Empty string'                                         => ['', 'ab', false],
            ' 2. Empty substring'                                      => ['abcd', '', true],
            ' 3. Empty string and empty substring'                     => ['', '', true],
            ' 4. String ending with substring'                         => ['abcd', 'cd', true],
            ' 5. String not ending with substring'                     => ['abcd', 'bc', false],
            ' 6. String ending with substring but with different case' => ['abcd', 'CD', false],
        ];
    }

    /**
     * @dataProvider dataEnsureLeft
     */
    public function testEnsureLeftStart($string, $substring, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->ensureLeft($substring)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataEnsureLeft()
    {
        return [
            ' 1. String starting with substring'                     => ['abcde', 'ab', 'abcde'],
            ' 2. String starting with substring, but different case' => ['abcde', 'AB', 'ABabcde'],
            ' 3. String not starting with substring'                 => ['cde', 'ab', 'abcde'],
        ];
    }

    /**
     * @dataProvider dataEnsureRight
     */
    public function testEnsureRight($string, $substring, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->ensureRight($substring)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataEnsureRight()
    {
        return [
            ' 1. String ending with substring'                     => ['abcde', 'de', 'abcde'],
            ' 2. String ending with substring, but different case' => ['abcde', 'DE', 'abcdeDE'],
            ' 3. String not ending with substring'                 => ['abc', 'de', 'abcde'],
        ];
    }

    /**
     * @dataProvider dataUpper
     */
    public function testUpper($string, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->upper()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataUpper()
    {
        return [
            ' 1. String' => ['abcde', 'ABCDE'],
        ];
    }

    /**
     * @dataProvider dataLower
     */
    public function testLower($string, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->lower()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataLower()
    {
        return [
            ' 1. String' => ['ABCDE', 'abcde'],
        ];
    }

    /**
     * @dataProvider dataUpperFirst
     */
    public function testUpperFirst($string, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->upperFirst()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataUpperFirst()
    {
        return [
            ' 1. String with only lower case chars'           => ['abcde', 'Abcde'],
            ' 2. String with both lower and upper case chars' => ['abcDE', 'AbcDE'],
        ];
    }

    /**
     * @dataProvider dataLowerFirst
     */
    public function testLowerFirst($string, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->lowerFirst()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataLowerFirst()
    {
        return [
            ' 1. String with only lower case chars'           => ['ABCDE', 'aBCDE'],
            ' 2. String with both lower and upper case chars' => ['ABCde', 'aBCde'],
        ];
    }

    /**
     * @dataProvider dataTitleize
     */
    public function testTitleize($string, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->titleize()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTitleize()
    {
        return [
            ' 1. String with only lower case chars'           => ['abcd efgh', 'Abcd Efgh'],
            ' 2. String with both lower and upper case chars' => ['abCD efgh', 'Abcd Efgh'],
        ];
    }

    /**
     * @dataProvider dataShuffle_result_must_contain_same_chars
     */
    public function testShuffle_result_must_contain_same_chars($string)
    {
        $expected = CaseSensitiveBinaryString::create($string)->chars();
        $result = CaseSensitiveBinaryString::create($string)
            ->shuffle()
            ->chars();
        $this->assertEquals($expected, $result, '', 0, 0, true);
    }

    public function dataShuffle_result_must_contain_same_chars()
    {
        return [
            ' 1. ' => ['abcde'],
        ];
    }

    /**
     * @dataProvider dataTrim
     */
    public function testTrim($string, $chars, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->trim($chars)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTrim()
    {
        return [
            ' 1. Trim whitespaces (default)' => ['   abcde   ', null, 'abcde'],
            ' 2. Trim specified chars'       => ['+-+abcde+-+', '+-', 'abcde'],
        ];
    }

    /**
     * @dataProvider dataTrimLeft
     */
    public function testTrimLeft($string, $chars, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->trimLeft($chars)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTrimLeft()
    {
        return [
            ' 1. Trim whitespaces (default)' => ['   abcde   ', null, 'abcde   '],
            ' 2. Trim specified chars'       => ['+-+abcde+-+', '+-', 'abcde+-+'],
        ];
    }

    /**
     * @dataProvider dataTrimRight
     */
    public function testTrimRight($string, $chars, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->trimRight($chars)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTrimRight()
    {
        return [
            ' 1. Trim whitespaces (default)' => ['   abcde   ', null, '   abcde'],
            ' 2. Trim specified chars'       => ['+-+abcde+-+', '+-', '+-+abcde'],
        ];
    }

    /**
     * @dataProvider dataAlignLeft
     */
    public function testAlignLeft($string, $size, $fill, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string);
        $result = $fill === NOT_PROVIDED
            ? $result->alignLeft($size)
            : $result->alignLeft($size, $fill);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataAlignLeft()
    {
        return [
            ' 1. Default fill'                 => ['abcde', 8, NOT_PROVIDED, 'abcde   '],
            ' 2. Fill with one char'           => ['abcde', 8, '.', 'abcde...'],
            ' 3. Fill with more than one char' => ['abcde', 8, '+-', 'abcde+-+'],
        ];
    }

    /**
     * @dataProvider dataAlignRight
     */
    public function testAlignRight($string, $size, $fill, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string);
        $result = $fill === NOT_PROVIDED
            ? $result->alignRight($size)
            : $result->alignRight($size, $fill);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataAlignRight()
    {
        return [
            ' 1. Default fill'                 => ['abcde', 8, NOT_PROVIDED, '   abcde'],
            ' 2. Dill with one char'           => ['abcde', 8, '.', '...abcde'],
            ' 3. Fill with more than one char' => ['abcde', 8, '+-', '+-+abcde'],
        ];
    }

    /**
     * @dataProvider dataCenter
     */
    public function testCenter($string, $size, $fill, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string);
        $result = $fill === NOT_PROVIDED
            ? $result->center($size)
            : $result->center($size, $fill);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataCenter()
    {
        return [
            ' 1. Default fill'                 => ['abcde', 10, NOT_PROVIDED, '  abcde   '],
            ' 2. Fill with one char'           => ['abcde', 10, '.', '..abcde...'],
            ' 3. Fill with more than one char' => ['abcde', 10, '+-', '+-abcde+-+'],
        ];
    }

    /**
     * @dataProvider dataReverse
     */
    public function testReverse($string, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->reverse()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataReverse()
    {
        return [
            ' 1. ' => ['abcde', 'edcba'],
        ];
    }

    /**
     * @dataProvider dataReplaceAll
     */
    public function testReplaceAll($string, $search, $replace, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->replaceAll($search, $replace)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataReplaceAll()
    {
        return [
            ' 1. Replace one string'                              => ['abocdxefXgh', 'x', '*', 'abocd*efXgh'],
            ' 2. Replace multiple strings with same string'       => ['abocdxefXgh', ['o', 'x'], '*', 'ab*cd*efXgh'],
            ' 3. Replace multiple strings with different strings' => ['abocdxefXgh', ['o', 'x'], ['*', '-'], 'ab*cd-efXgh'],
        ];
    }

    /**
     * @dataProvider dataContains
     */
    public function testContains($string, $substring, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->contains($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataContains()
    {
        return [
            ' 1. String containing substring'     => ['abcdef', 'cd', true],
            ' 2. String not containing substring' => ['abcdef', 'ce', false],
        ];
    }

    /**
     * @dataProvider dataContainsAny
     */
    public function testContainsAny($string, $substrings, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->containsAny($substrings);
        $this->assertEquals($expected, $result);
    }

    public function dataContainsAny()
    {
        return [
            ' 1. String containing no substrings'                    => ['abcdefefgh', ['abx', 'cdx', 'fgx'], false],
            ' 2. String containing one substring'                    => ['abcdefefgh', ['abx', 'cde', 'fgx'], true],
            ' 3. String containing one substring, but not same case' => ['abcdefefgh', ['abx', 'CDE', 'fgx'], false],
        ];
    }

    /**
     * @dataProvider dataContainsAll
     */
    public function testContainsAll($string, $substrings, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->containsAll($substrings);
        $this->assertEquals($expected, $result);
    }

    public function dataContainsAll()
    {
        return [
            ' 1. String containing no substrings'                     => ['abcdefefgh', ['abx', 'cdx', 'fgx'], false],
            ' 2. String containing one substring, but not all'        => ['abcdefefgh', ['abx', 'cde', 'fgx'], false],
            ' 3. String containing all substrings'                    => ['abcdefefgh', ['abc', 'cde', 'fgh'], true],
            ' 4. String containing all substrings, but not same case' => ['abcdefefgh', ['abc', 'CDE', 'fgh'], false],
        ];
    }

    /**
     * @dataProvider dataIsSubstringOf
     */
    public function testIsSubstringOf($string, $anotherString, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->isSubstringOf($anotherString);
        $this->assertEquals($expected, $result);
    }

    public function dataIsSubstringOf()
    {
        return [
            ' 1. Is not substring'                => ['def', 'abcdxfgh', false],
            ' 2. Is substring'                    => ['def', 'abcdefgh', true],
            ' 3. Is substring, but not same case' => ['dEf', 'abcdefgh', false],
        ];
    }

    /**
     * @dataProvider dataIsSubstringOfAny
     */
    public function testIsSubstringOfAny($string, $strings, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->isSubstringOfAny($strings);
        $this->assertEquals($expected, $result);
    }

    public function dataIsSubstringOfAny()
    {
        return [
            ' 1. Is substring of no strings'                    => ['def', ['abghrtil', 'kittokf', 'rtolllf'], false],
            ' 2. Is substring of one string'                    => ['def', ['abghrtil', 'kidefkf', 'rtolllf'], true],
            ' 3. Is substring of one string, but not same case' => ['dEf', ['abghrtil', 'kidefkf', 'rtolllf'], false],
        ];
    }

    /**
     * @dataProvider dataIsSubstringOfAll
     */
    public function testIsSubstringOfAll($string, $strings, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->isSubstringOfAll($strings);
        $this->assertEquals($expected, $result);
    }

    public function dataIsSubstringOfAll()
    {
        return [
            ' 1. Is substring of no strings'                     => ['def', ['abghrtil', 'kittokf', 'rtolllf'], false],
            ' 2. Is substring of one string'                     => ['def', ['abghrtil', 'kidefkf', 'rtolllf'], false],
            ' 3. Is substring of one all strings'                => ['def', ['abghdefl', 'kidefkf', 'deflllf'], true],
            ' 4. Is substring of all strings, but not same case' => ['def', ['abgdefil', 'kidEfkf', 'rtoldef'], false],
        ];
    }

    /**
     * @dataProvider dataIs
     */
    public function testIs($string, $otherString, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->is($otherString);
        $this->assertEquals($expected, $result);
    }

    public function dataIs()
    {
        return [
            ' 1. Same strings'                    => ['abCde', 'abCde', true],
            ' 2. Same strings but incorrect case' => ['abCde', 'abcde', false],
        ];
    }

    /**
     * @dataProvider dataIsAny
     */
    public function testIsAny($string, $otherString, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->isAny($otherString);
        $this->assertEquals($expected, $result);
    }

    public function dataIsAny()
    {
        return [
            ' 1. Empty array of strings'             => ['abCde', [], false],
            ' 2. String in array'                    => ['abCde', ['fghij', 'abCde', 'klmn'], true],
            ' 3. String in array but incorrect case' => ['abcde', ['fghij', 'abCde', 'klmn'], false],
            ' 4. String not in array'                => ['abCde', ['fghij', 'opqrs', 'klmn'], false],
        ];
    }

    /**
     * @dataProvider dataCountOf
     */
    public function testCountOf($string, $substring, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->countOf($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataCountOf()
    {
        return [
            ' 1. String containing the substring'                     => ['abcdbcef', 'bc', 2],
            ' 2. String containing the substring with different case' => ['abcdBcef', 'bc', 1],
        ];
    }

    /**
     * @dataProvider dataCharAt
     */
    public function testCharAt($string, $index, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->charAt($index);
        $this->assertEquals($expected, $result);
    }

    public function dataCharAt()
    {
        return [
            ' 1. ' => ['abcde', 1, 'b'],
        ];
    }

    /**
     * @dataProvider dataSqueeze
     */
    public function testSqueeze($string, $char, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string);
        $result = $char === NOT_PROVIDED
            ? $result->squeeze()
            : $result->squeeze($char);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataSqueeze()
    {
        return [
            ' 1. Default char' => ['a   bc  de', NOT_PROVIDED, 'a bc de'],
            ' 2. Char given'   => ['a---bc--de', '-', 'a-bc-de'],
        ];
    }

    /**
     * @dataProvider dataTruncate
     */
    public function testTruncate($string, $size, $ellipsis, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string);
        $result = $ellipsis === NOT_PROVIDED
            ? $result->truncate($size)
            : $result->truncate($size, $ellipsis);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTruncate()
    {
        return [
            ' 1. Default ellipsis'                  => ['abcdefgh', 3, NOT_PROVIDED, 'abc'],
            ' 2. Default ellipsis, string too long' => ['abcdefgh', 10, NOT_PROVIDED, 'abcdefgh'],
            ' 3. Ellipsis given'                    => ['abcdefgh', 6, '...', 'abc...'],
        ];
    }

    /**
     * @dataProvider dataTruncateLeft
     */
    public function testTruncateLeft($string, $size, $ellipsis, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string);
        $result = $ellipsis === NOT_PROVIDED
            ? $result->truncateLeft($size)
            : $result->truncateLeft($size, $ellipsis);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTruncateLeft()
    {
        return [
            ' 1. Default ellipsis'                  => ['abcdefgh', 3, NOT_PROVIDED, 'fgh'],
            ' 2. Default ellipsis, string too long' => ['abcdefgh', 10, NOT_PROVIDED, 'abcdefgh'],
            ' 3. Ellipsis given'                    => ['abcdefgh', 6, '...', '...fgh'],
        ];
    }

    /**
     * @dataProvider dataTruncateMiddle
     */
    public function testTruncateMiddle($string, $size, $ellipsis, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string);
        $result = $ellipsis === NOT_PROVIDED
            ? $result->truncateMiddle($size)
            : $result->truncateMiddle($size, $ellipsis);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTruncateMiddle()
    {
        return [
            ' 1. Default ellipsis'                  => ['abcdefgh', 3, NOT_PROVIDED, 'agh'],
            ' 2. Default ellipsis, string too long' => ['abcdefgh', 10, NOT_PROVIDED, 'abcdefgh'],
            ' 3. Ellipsis given'                    => ['abcdefgh', 6, '...', 'a...gh'],
        ];
    }

    public function testEscapeControlChars()
    {
        $this->assertEquals('abc\ndef', CaseSensitiveBinaryString::create("abc\ndef")->escapeControlChars()->toString());
    }

    public function testReplace()
    {
        $result = CaseSensitiveBinaryString::create('abc')
            ->replace('def');
        $this->assertEquals('def', $result->toString());
        $this->assertInstanceOf(CaseSensitiveBinaryString::class, $result);
    }

    /**
     * @dataProvider dataLines
     */
    public function testLines($string, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->lines()
            ->toArray();
        $this->assertEquals($expected, $result);
    }

    public function dataLines()
    {
        return [
            ' 1. No empty lines'              => ["ab\ncd\ref\r\ngh", ['ab', 'cd', 'ef', 'gh']],
            ' 2. Empty line at the beginning' => ["\nab", ['', 'ab']],
            ' 3. Empty line at the end'       => ["ab\n", ['ab', '']],
            ' 4. Empty string'                => ["", ['']],
        ];
    }

    /**
     * @dataProvider dataTransform
     */
    public function testTransform($string, $callable, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->transform($callable);
        $this->assertInstanceOf(CaseSensitiveBinaryString::class, $result);
        $this->assertEquals($expected, $result->toString());
    }

    public function dataTransform()
    {
        return [
            ' 1. Result is a string' => ['abcd', function($s) {
                    return $s->reverse();
                }, 'dcba'],
            ' 2. Result is an integer' => ['abcd', function($s) {
                    return $s->length();
                }, '4'],
        ];
    }

    /**
     * @dataProvider dataConvert
     */
    public function testConvert($string, $callable, $expectedType, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->convert($callable);
        $this->assertEquals($expectedType, gettype($result));
        $this->assertEquals($expected,
            is_object($result)
                ? $result->toString()
                : $result);
    }

    public function dataConvert()
    {
        return [
            ' 1. Result is a string' => ['abcd', function($s) {
                    return $s->reverse();
                }, 'object', 'dcba'],
            ' 2. Result is an integer' => ['abcd', function($s) {
                    return $s->length();
                }, 'integer', '4'],
        ];
    }

    /**
     * @dataProvider dataIsAcii
     */
    public function testIsAscii($string, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->isAscii();
        $this->assertEquals($expected, $result);
    }

    public function dataIsAcii()
    {
        return [
            ' 1. ASCII string'     => ['abcde', true],
            ' 2. Non ASCII string' => ['àbcdé', false],
        ];
    }

    /**
     * @dataProvider dataFill
     */
    public function testFill($size, $fill, $expected)
    {
        $result = CaseSensitiveBinaryString::create()
            ->fill($size, $fill);
        $this->assertEquals($expected, $result);
    }

    public function dataFill()
    {
        return [
            ' 1. Fill with one char'  => [3, '*', '***'],
            ' 2. Fill with two chars' => [5, '*-', '*-*-*'],
        ];
    }

    /**
     * @dataProvider dataRepeatToSize
     */
    public function testRepeatToSize($string, $size, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->repeatToSize($size);
        $this->assertEquals($expected, $result);
    }

    public function dataRepeatToSize()
    {
        return [
            ' 1. Repeat one char'  => ['*', 3, '***'],
            ' 2. Repeat two chars' => ['*-', 5, '*-*-*'],
        ];
    }

    /**
     * @dataProvider dataCaseTransform
     */
    public function testCaseTransform($string, $expected)
    {
        $transformer = new BasicCaseTransformer();
        $result = CaseSensitiveBinaryString::create($string)
            ->caseTransform($transformer)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataCaseTransform()
    {
        return [
            ' 1. Separated words and digits' => ['abc, Def, 123, GHI.', 'abc|Def|123|GHI'],
            ' 2. Digits stuck to words'      => ['abc123, 456Def.', 'abc|123|456|Def'],
            ' 3. Words stuck together'       => ['abcDef, GHIjkl', 'abc|Def|GHI|jkl'],
        ];
    }

    /**
     * @dataProvider dataCut
     */
    public function testCut($string, $cuts, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->cut($cuts)
            ->toArray();
        $this->assertEquals($expected, $result);
    }

    public function dataCut()
    {
        return [
            ' 1. Oone cut'      => ['abcdefgh', 3, ['abc', 'defgh']],
            ' 2. Multiple cuts' => ['abcdefgh', [3, 5], ['abc', 'de', 'fgh']],
        ];
    }

    /**
     * @dataProvider dataSplit
     */
    public function testSplit($string, $size, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string);
        $result = $size === NOT_PROVIDED
            ? $result->split()
            : $result->split($size);
        $result = $result->toArray();
        $this->assertEquals($expected, $result);
    }

    public function dataSplit()
    {
        return [
            ' 1. Default size' => ['abcde', NOT_PROVIDED, ['a', 'b', 'c', 'd', 'e']],
            ' 2. Size = 2'     => ['abcde', 2, ['ab', 'cd', 'e']],
        ];
    }

    /**
     * @dataProvider dataExplode
     */
    public function testExplode($string, $delimiter, $limit, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->explode($delimiter, $limit)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataExplode()
    {
        return [
            ' 1. No limit'   => ['abxcdxefXgh', 'x', PHP_INT_MAX, ['ab', 'cd', 'efXgh']],
            ' 2. With limit' => ['abxcdxefXgh', 'x', 2, ['ab', 'cdxefXgh']],
        ];
    }

    /**
     * @dataProvider dataOccurences
     */
    public function testOccurences($string, $substrings, $expected)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->occurences($substrings)
            ->info([SubstringListInterface::INFO_START, SubstringListInterface::INFO_END]);
        $this->assertEquals($expected, $result);
    }

    public function dataOccurences()
    {
        return [
            ' 1. One substring with no occurences'              => ['abacdababacd', 'abb', []],
            ' 2. One substring with occurences'                 => ['abacdababacd', 'aba', [[0, 3], [5, 8]]],
            ' 3. One substring with occurences, different case' => ['aBacdababacd', 'aba', [[5, 8]]],
        ];
    }

    /**
     * @dataProvider dataSeparate
     */
    public function testSeparate($string, $delimiters, $expectedSubstrings, $expectedRest)
    {
        $result = CaseSensitiveBinaryString::create($string)
            ->separate($delimiters);
        $this->assertEquals($expectedSubstrings, $result->toArray());
        $this->assertEquals($expectedRest, $result->replace('*')->patch()->toString());
    }

    public function dataSeparate()
    {
        return [
            ' 1. Multiple delimiters' => ['1a2b3A4', ['a', 'b'], ['1', '2', '3A4'], '*a*b*'],
        ];
    }
    
    public function testToCaseInsensitive()
    {
        $result = CaseSensitiveBinaryString::create('abc')
            ->toCaseInsensitive();
        $this->assertInstanceOf(CaseInsensitiveBinaryString::class, $result);
        $this->assertEquals('abc', $result->toString());
    }
    
    public function testSelect()
    {
        $result = CaseSensitiveBinaryString::create('abc')
            ->select();
        $this->assertInstanceOf(CaseSensitiveBinarySubstringBuilder::class, $result);
    }

}
