<?php

use LucLeroy\Strings\CaseInsensitiveBinaryString;
use LucLeroy\Strings\CaseSensitiveBinaryString;
use LucLeroy\Strings\SubstringBuilder\CaseInsensitiveBinarySubstringBuilder;
use LucLeroy\Strings\SubstringList\SubstringListInterface;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/BasicCaseTransformer.php';

defined('NOT_PROVIDED') || define('NOT_PROVIDED', uniqid());

class CaseInsensitiveBinaryStringTest extends TestCase
{

    public function testCreate()
    {
        $this->assertInstanceOf(CaseInsensitiveBinaryString::class, CaseInsensitiveBinaryString::create('abcd'));
        $this->assertEquals('abcd', CaseInsensitiveBinaryString::create('abcd')->toString());
    }

    /**
     * @dataProvider dataStartsWith
     */
    public function testStartsWith($string, $substring, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->startsWith($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataStartsWith()
    {
        return [
            ' 1. Empty string'                                           => ['', 'ab', false],
            ' 2. Empty substring'                                        => ['abcd', '', true],
            ' 3. Empty string and empty substring'                       => ['', '', true],
            ' 4. String starting with substring, same case'              => ['abcd', 'ab', true],
            ' 5. String not starting with substring'                     => ['abcd', 'bc', false],
            ' 6. String starting with substring but with different case' => ['abcd', 'AB', true],
        ];
    }

    /**
     * @dataProvider dataStartsWithAny
     */
    public function testStartsWithAny($string, $substring, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->startsWithAny($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataStartsWithAny()
    {
        return [
            ' 1. String starting with no substrings'                    => ['abcdefgh', ['cd', 'de', 'fg'], false],
            ' 2. String starting with one substring'                    => ['abcdefgh', ['cd', 'de', 'ab'], true],
            ' 3. String starting with one substring, but not same case' => ['abcdefgh', ['cd', 'de', 'aB'], true],
        ];
    }

    /**
     * @dataProvider dataEndsWithAny
     */
    public function testEndsWithAny($string, $substring, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->endsWithAny($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataEndsWithAny()
    {
        return [
            ' 1. String ending with no substrings'                    => ['abcdefgh', ['cd', 'de', 'fg'], false],
            ' 2. String ending with one substring'                    => ['abcdefgh', ['cd', 'gh', 'fg'], true],
            ' 3. String ending with one substring, but not same case' => ['abcdefgh', ['cd', 'gH', 'fg'], true],
        ];
    }

    /**
     * @dataProvider dataEndsWith
     */
    public function testEndsWith($string, $substring, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
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
            ' 6. String ending with substring but with different case' => ['abcd', 'CD', true],
        ];
    }

    /**
     * @dataProvider dataEnsureLeft
     */
    public function testEnsureLeftStart($string, $substring, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->ensureLeft($substring)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataEnsureLeft()
    {
        return [
            ' 1. String starting with substring'                     => ['abcde', 'ab', 'abcde'],
            ' 2. String starting with substring, but different case' => ['abcde', 'AB', 'abcde'],
            ' 3. String not starting with substring'                 => ['cde', 'ab', 'abcde'],
        ];
    }

    /**
     * @dataProvider dataEnsureRight
     */
    public function testEnsureRight($string, $substring, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->ensureRight($substring)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataEnsureRight()
    {
        return [
            ' 1. String ending with substring'                     => ['abcde', 'de', 'abcde'],
            ' 2. String ending with substring, but different case' => ['abcde', 'DE', 'abcde'],
            ' 3. String not ending with substring'                 => ['abc', 'de', 'abcde'],
        ];
    }

    /**
     * @dataProvider dataReplaceAll
     */
    public function testReplaceAll($string, $search, $replace, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->replaceAll($search, $replace)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataReplaceAll()
    {
        return [
            ' 1. Replace one string'                              => ['abocdxefXgh', 'x', '*', 'abocd*ef*gh'],
            ' 2. Replace multiple strings with same string'       => ['abocdxefXgh', ['o', 'x'], '*', 'ab*cd*ef*gh'],
            ' 3. Replace multiple strings with different strings' => ['abocdxefXgh', ['o', 'x'], ['*', '-'], 'ab*cd-ef-gh'],
        ];
    }

    /**
     * @dataProvider dataContains
     */
    public function testContains($string, $substring, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->contains($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataContains()
    {
        return [
            ' 1. String containing substring'                 => ['abcdef', 'cd', true],
            ' 2. String containing substring, different case' => ['abcDef', 'cd', true],
            ' 3. String not containing substring'             => ['abcdef', 'ce', false],
        ];
    }

    /**
     * @dataProvider dataContainsAny
     */
    public function testContainsAny($string, $substrings, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->containsAny($substrings);
        $this->assertEquals($expected, $result);
    }

    public function dataContainsAny()
    {
        return [
            ' 1. String containing no substrings'                    => ['abcdefefgh', ['abx', 'cdx', 'fgx'], false],
            ' 2. String containing one substring'                    => ['abcdefefgh', ['abx', 'cde', 'fgx'], true],
            ' 3. String containing one substring, but not same case' => ['abcdefefgh', ['abx', 'CDE', 'fgx'], true],
        ];
    }

    /**
     * @dataProvider dataContainsAll
     */
    public function testContainsAll($string, $substrings, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->containsAll($substrings);
        $this->assertEquals($expected, $result);
    }

    public function dataContainsAll()
    {
        return [
            ' 1. String containing no substrings'                     => ['abcdefefgh', ['abx', 'cdx', 'fgx'], false],
            ' 2. String containing one substring, but not all'        => ['abcdefefgh', ['abx', 'cde', 'fgx'], false],
            ' 3. String containing all substrings'                    => ['abcdefefgh', ['abc', 'cde', 'fgh'], true],
            ' 4. String containing all substrings, but not same case' => ['abcdefefgh', ['abc', 'CDE', 'fgh'], true],
        ];
    }

    /**
     * @dataProvider dataIsSubstringOf
     */
    public function testIsSubstringOf($string, $anotherString, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->isSubstringOf($anotherString);
        $this->assertEquals($expected, $result);
    }

    public function dataIsSubstringOf()
    {
        return [
            ' 1. Is not substring'                => ['def', 'abcdxfgh', false],
            ' 2. Is substring'                    => ['def', 'abcdefgh', true],
            ' 3. Is substring, but not same case' => ['dEf', 'abcdefgh', true],
        ];
    }

    /**
     * @dataProvider dataIsSubstringOfAny
     */
    public function testIsSubstringOfAny($string, $strings, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->isSubstringOfAny($strings);
        $this->assertEquals($expected, $result);
    }

    public function dataIsSubstringOfAny()
    {
        return [
            ' 1. Is substring of no strings'                    => ['def', ['abghrtil', 'kittokf', 'rtolllf'], false],
            ' 2. Is substring of one string'                    => ['def', ['abghrtil', 'kidefkf', 'rtolllf'], true],
            ' 3. Is substring of one string, but not same case' => ['dEf', ['abghrtil', 'kidefkf', 'rtolllf'], true],
        ];
    }

    /**
     * @dataProvider dataIsSubstringOfAll
     */
    public function testIsSubstringOfAll($string, $strings, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->isSubstringOfAll($strings);
        $this->assertEquals($expected, $result);
    }

    public function dataIsSubstringOfAll()
    {
        return [
            ' 1. Is substring of no strings'                     => ['def', ['abghrtil', 'kittokf', 'rtolllf'], false],
            ' 2. Is substring of one string'                     => ['def', ['abghrtil', 'kidefkf', 'rtolllf'], false],
            ' 3. Is substring of one all strings'                => ['def', ['abghdefl', 'kidefkf', 'deflllf'], true],
            ' 4. Is substring of all strings, but not same case' => ['def', ['abgdefil', 'kidEfkf', 'rtoldef'], true],
        ];
    }

    /**
     * @dataProvider dataIs
     */
    public function testIs($string, $otherString, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->is($otherString);
        $this->assertEquals($expected, $result);
    }

    public function dataIs()
    {
        return [
            ' 1. Same strings'                    => ['abCde', 'abCde', true],
            ' 2. Same strings but incorrect case' => ['abCde', 'abcde', true],
        ];
    }

    /**
     * @dataProvider dataIsAny
     */
    public function testIsAny($string, $otherString, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->isAny($otherString);
        $this->assertEquals($expected, $result);
    }

    public function dataIsAny()
    {
        return [
            ' 1. Empty array of strings'             => ['abCde', [], false],
            ' 2. String in array'                    => ['abCde', ['fghij', 'abCde', 'klmn'], true],
            ' 3. String in array but incorrect case' => ['abcde', ['fghij', 'abCde', 'klmn'], true],
            ' 4. String not in array'                => ['abCde', ['fghij', 'opqrs', 'klmn'], false],
        ];
    }

    /**
     * @dataProvider dataCountOf
     */
    public function testCountOf($string, $substring, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->countOf($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataCountOf()
    {
        return [
            ' 1. String containing the substring'                     => ['abcdbcef', 'bc', 2],
            ' 2. String containing the substring with different case' => ['abcdBcef', 'bc', 2],
        ];
    }
    
    /**
     * @dataProvider dataExplode
     */
    public function testExplode($string, $delimiter, $limit, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->explode($delimiter, $limit)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataExplode()
    {
        return [
            ' 1. No limit'   => ['abxcdxefXgh', 'x', PHP_INT_MAX, ['ab', 'cd', 'ef', 'gh']],
            ' 2. With limit' => ['abxcdXefXgh', 'x', 3, ['ab', 'cd', 'efXgh']],
        ];
    }
    
    /**
     * @dataProvider dataOccurences
     */
    public function testOccurences($string, $substrings, $expected)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->occurences($substrings)
            ->info([SubstringListInterface::INFO_START, SubstringListInterface::INFO_END]);
        $this->assertEquals($expected, $result);
    }

    public function dataOccurences()
    {
        return [
            ' 1. One substring with no occurences' => ['abacdababacd', 'abb', []],
            ' 2. One substring with occurences'    => ['abacdababacd', 'aba', [[0, 3], [5, 8]]],
            ' 3. One substring with occurences, different case'    => ['aBacdababacd', 'aba', [[0, 3], [5, 8]]],
        ];
    }

    /**
     * @dataProvider dataSeparate
     */
    public function testSeparate($string, $delimiters, $expectedSubstrings, $expectedRest)
    {
        $result = CaseInsensitiveBinaryString::create($string)
            ->separate($delimiters);
        $this->assertEquals($expectedSubstrings, $result->toArray());
        $this->assertEquals($expectedRest, $result->replace('*')->patch()->toString());
    }

    public function dataSeparate()
    {
        return [
            ' 1. Multiple delimiters' => ['1a2b3A4', ['a', 'b'], ['1', '2', '3', '4'], '*a*b*A*'],
        ];
    }
    
    public function testToCaseSensitive()
    {
        $result = CaseInsensitiveBinaryString::create('abc')
            ->toCaseSensitive();
        $this->assertInstanceOf(CaseSensitiveBinaryString::class, $result);
        $this->assertEquals('abc', $result->toString());
    }
    
    public function testSelect()
    {
        $result = CaseInsensitiveBinaryString::create('abc')
            ->select();
        $this->assertInstanceOf(CaseInsensitiveBinarySubstringBuilder::class, $result);
    }
}
