<?php

use LucLeroy\Strings\CaseInsensitiveUnicodeString;
use LucLeroy\Strings\CaseSensitiveUnicodeString;
use LucLeroy\Strings\SubstringBuilder\CaseSensitiveUnicodeSubstringBuilder;
use LucLeroy\Strings\SubstringList\SubstringListInterface;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/BasicCaseTransformer.php';

defined('NOT_PROVIDED') || define('NOT_PROVIDED', uniqid());

class CaseSensitiveUnicodeStringTest extends TestCase
{

    /**
     * @dataProvider dataCreate
     */
    public function testCreate($string, $encoding, $expectedEncoding, $expected)
    {
        $result = $encoding === NOT_PROVIDED
            ? CaseSensitiveUnicodeString::create($string)
            : CaseSensitiveUnicodeString::create($string, $encoding);
        $this->assertInstanceOf(CaseSensitiveUnicodeString::class, $result);
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

    public function test_ToString()
    {
        $this->assertEquals('àéîôù', CaseSensitiveUnicodeString::create('àéîôù') . '');
    }

    /**
     * 
     * @dataProvider dataChars
     */
    public function testChars($string, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->chars();
        $this->assertEquals($expected, $result);
    }

    public function dataChars()
    {
        return [
            ' 1. Empty string'     => ['', []],
            ' 2. Non empty string' => ['àéî', ['à', 'é', 'î']],
        ];
    }

    /**
     * 
     * @dataProvider dataClear
     */
    public function testClear($string)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->clear()
            ->toString();
        $this->assertEquals('', $result);
    }

    public function dataClear()
    {
        return [
            ' 1. Empty string'     => [''],
            ' 2. Non empty string' => ['àéî'],
        ];
    }

    /**
     * @dataProvider dataLength
     */
    public function testLength($string, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->length();
        $this->assertEquals($expected, $result);
    }

    public function dataLength()
    {
        return [
            ' 1. Empty string'     => ['', 0],
            ' 2. Non empty string' => ['àéî', 3],
        ];
    }

    /**
     * @dataProvider dataIsEmpty
     */
    public function testIsEmpty($string, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->isEmpty();
        $this->assertEquals($expected, $result);
    }

    public function dataIsEmpty()
    {
        return [
            ' 1. Empty string'     => ['', true],
            ' 2. Non empty string' => ['àéî', false],
        ];
    }

    /**
     * @dataProvider dataAppend
     */
    public function testAppend($string, $stringToAppend, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->append($stringToAppend)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataAppend()
    {
        return [
            ' 1. Append an empty string to an empty string'       => ['', '', ''],
            ' 2. Append a non empty string to a non empty string' => ['àé', 'îô', 'àéîô'],
            ' 3. Append an emptystring to a non empty string'     => ['àé', '', 'àé'],
            ' 4. Append a non empty string to an empty string'    => ['', 'àé', 'àé'],
        ];
    }

    /**
     * @dataProvider dataPrepend
     */
    public function testPrepend($string, $stringToPrepend, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->prepend($stringToPrepend)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataPrepend()
    {
        return [
            ' 1. Prepend an empty string to an empty string'       => ['', '', ''],
            ' 2. Prepend a non empty string to a non empty string' => ['àé', 'îô', 'îôàé'],
            ' 3. Prepend an empty string to a non empty string'    => ['àé', '', 'àé'],
            ' 4. Prepend a non empty string to an empty string'    => ['', 'àé', 'àé'],
        ];
    }

    /**
     * @dataProvider dataSurroundWith
     */
    public function testSurroundWith($string, $surroundLeft, $surroundRight, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string);
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
            ' 4. Surround non empty string with empty string'    => ['àé', '', null, 'àé'],
            ' 5. Surround non empty string with same char'       => ['àé', '*', null, '*àé*'],
            ' 6. Surround non empty string with different chars' => ['àé', '(', ')', '(àé)'],
        ];
    }

    /**
     * @dataProvider dataRepeat
     */
    public function testRepeat($string, $multiplier, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string);
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
            ' 4. Repeat non empty string, multiplier = 0' => ['àé', 0, ''],
            ' 5. Repeat non empty string, multiplier = 1' => ['àé', 1, 'àé'],
            ' 6. Repeat non empty string, multiplier = 3' => ['àé', 3, 'àéàéàé'],
        ];
    }

    /**
     * @dataProvider dataStartsWith
     */
    public function testStartsWith($string, $substring, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
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
            ' 5. String not starting with substring, case sensitive'     => ['àéîô', 'éî', false],
            ' 6. String starting with substring but with different case' => ['àéîô', 'ÀÉ', false],
        ];
    }

    /**
     * @dataProvider dataStartsWithAny
     */
    public function testStartsWithAny($string, $substring, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->startsWithAny($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataStartsWithAny()
    {
        return [
            ' 1. String starting with no substrings'                    => ['àéîôùèçâ', ['îô', 'çâ', 'ùè'], false],
            ' 2. String starting with one substring'                    => ['àéîôùèçâ', ['îô', 'àé', 'ùè'], true],
            ' 3. String starting with one substring, but not same case' => ['àéîôùèçâ', ['îô', 'ÀÉ', 'ùè'], false],
        ];
    }

    /**
     * @dataProvider dataEndsWithAny
     */
    public function testEndsWithAny($string, $substring, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->endsWithAny($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataEndsWithAny()
    {
        return [
            ' 1. String ending with no substrings'                    => ['àéîôùèçâ', ['ôù', 'àé', 'éî'], false],
            ' 2. String ending with one substring'                    => ['àéîôùèçâ', ['ôù', 'çâ', 'éî'], true],
            ' 3. String ending with one substring, but not same case' => ['àéîôùèçâ', ['ôù', 'ÇÂ', 'éî'], false],
        ];
    }

    /**
     * @dataProvider dataEndsWith
     */
    public function testEndsWith($string, $substring, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
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
            ' 6. String ending with substring but with different case' => ['àéîô', 'ÎÔ', false],
        ];
    }

    /**
     * @dataProvider dataEnsureLeft
     */
    public function testEnsureLeftStart($string, $substring, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->ensureLeft($substring)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataEnsureLeft()
    {
        return [
            ' 1. String starting with substring'                     => ['àéîôù', 'àé', 'àéîôù'],
            ' 2. String starting with substring, but different case' => ['àéîôù', 'ÀÉ', 'ÀÉàéîôù'],
            ' 3. String not starting with substring'                 => ['îôù', 'àé', 'àéîôù'],
        ];
    }

    /**
     * @dataProvider dataEnsureRight
     */
    public function testEnsureRight($string, $substring, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->ensureRight($substring)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataEnsureRight()
    {
        return [
            ' 1. String ending with substring'                     => ['àéîôù', 'ôù', 'àéîôù'],
            ' 2. String ending with substring, but different case' => ['àéîôù', 'ÔÙ', 'àéîôùÔÙ'],
            ' 3. String not ending with substring'                 => ['àéîôù', 'îô', 'àéîôùîô'],
        ];
    }

    /**
     * @dataProvider dataUpper
     */
    public function testUpper($string, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->upper()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataUpper()
    {
        return [
            ' 1. ' => ['àéîôù', 'ÀÉÎÔÙ'],
        ];
    }

    /**
     * @dataProvider dataLower
     */
    public function testLower($string, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->lower()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataLower()
    {
        return [
            ' 1. ' => ['ÀÉÎÔÙ', 'àéîôù'],
        ];
    }

    /**
     * @dataProvider dataUpperFirst
     */
    public function testUpperFirst($string, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->upperFirst()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataUpperFirst()
    {
        return [
            ' 1. String with only lower case chars'           => ['àéîôù', 'Àéîôù'],
            ' 2. String with both lower and upper case chars' => ['àéîÔÙ', 'ÀéîÔÙ'],
        ];
    }

    /**
     * @dataProvider dataLowerFirst
     */
    public function testLowerFirst($string, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->lowerFirst()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataLowerFirst()
    {
        return [
            ' 1. String with only lower case chars'           => ['ÀÉÎÔÙ', 'àÉÎÔÙ'],
            ' 2. String with both lower and upper case chars' => ['ÀÉÎôù', 'àÉÎôù'],
        ];
    }

    /**
     * @dataProvider dataTitleize
     */
    public function testTitleize($string, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->titleize()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTitleize()
    {
        return [
            ' 1. String with only lower case chars'           => ['àéîô ùèçâ', 'Àéîô Ùèçâ'],
            ' 2. String with both lower and upper case chars' => ['àéÎÔ ùèçâ', 'Àéîô Ùèçâ'],
        ];
    }

    /**
     * @dataProvider dataShuffle_result_must_contain_same_chars
     */
    public function testShuffle_result_must_contain_same_chars($string)
    {
        $expected = CaseSensitiveUnicodeString::create($string)->chars();
        $result = CaseSensitiveUnicodeString::create($string)
            ->shuffle()
            ->chars();
        $this->assertEquals($expected, $result, '', 0, 0, true);
    }

    public function dataShuffle_result_must_contain_same_chars()
    {
        return [
            ' 1. ' => ['àéîôù'],
        ];
    }

    /**
     * @dataProvider dataTrim
     */
    public function testTrim($string, $chars, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->trim($chars)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTrim()
    {
        return [
            ' 1. Trim whitespaces (default)' => ['   àéîôù   ', null, 'àéîôù'],
            ' 2. Trim specified chars'       => ['+-+àéîôù+-+', '+-', 'àéîôù'],
            ' 3. Trim non ASCII chars'       => ['€€€àéîôù€€€', '€', 'àéîôù'],
        ];
    }

    /**
     * @dataProvider dataTrimLeft
     */
    public function testTrimLeft($string, $chars, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->trimLeft($chars)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTrimLeft()
    {
        return [
            ' 1. Trim whitespaces (default)' => ['   àéîôù   ', null, 'àéîôù   '],
            ' 2. Trim specified chars'       => ['+-+àéîôù+-+', '+-', 'àéîôù+-+'],
            ' 3. Trim non ascii chars'       => ['€€€àéîôù€€€', '€', 'àéîôù€€€'],
        ];
    }

    /**
     * @dataProvider dataTrimRight
     */
    public function testTrimRight($string, $chars, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->trimRight($chars)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTrimRight()
    {
        return [
            ' 1. Trim whitespaces (default)' => ['   àéîôù   ', null, '   àéîôù'],
            ' 2. Trim specified chars'       => ['+-+àéîôù+-+', '+-', '+-+àéîôù'],
            ' 2. Trim non ASCII chars'       => ['€€€àéîôù€€€', '€', '€€€àéîôù'],
        ];
    }

    /**
     * @dataProvider dataAlignLeft
     */
    public function testAlignLeft($string, $size, $fill, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string);
        $result = $fill === NOT_PROVIDED
            ? $result->alignLeft($size)
            : $result->alignLeft($size, $fill);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataAlignLeft()
    {
        return [
            ' 1. Default fill'                 => ['àéîôù', 8, NOT_PROVIDED, 'àéîôù   '],
            ' 2. Fill with one char'           => ['àéîôù', 8, '.', 'àéîôù...'],
            ' 3. Fill with more than one char' => ['àéîôù', 8, '+-', 'àéîôù+-+'],
            ' 3. Fill with mnon ASCII chars'   => ['àéîôù', 8, '€', 'àéîôù€€€'],
        ];
    }

    /**
     * @dataProvider dataAlignRight
     */
    public function testAlignRight($string, $size, $fill, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string);
        $result = $fill === NOT_PROVIDED
            ? $result->alignRight($size)
            : $result->alignRight($size, $fill);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataAlignRight()
    {
        return [
            ' 1. Default fill'                 => ['àéîôù', 8, NOT_PROVIDED, '   àéîôù'],
            ' 2. Fill with one char'           => ['àéîôù', 8, '.', '...àéîôù'],
            ' 3. Fill with more than one char' => ['àéîôù', 8, '+-', '+-+àéîôù'],
            ' 3. Fill with non ASCII charsr'   => ['àéîôù', 8, '€', '€€€àéîôù'],
        ];
    }

    /**
     * @dataProvider dataCenter
     */
    public function testCenter($string, $size, $fill, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string);
        $result = $fill === NOT_PROVIDED
            ? $result->center($size)
            : $result->center($size, $fill);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataCenter()
    {
        return [
            ' 1. Default fill'                 => ['àéîôù', 10, NOT_PROVIDED, '  àéîôù   '],
            ' 2. Fill with one char'           => ['àéîôù', 10, '.', '..àéîôù...'],
            ' 3. Fill with more than one char' => ['àéîôù', 10, '+-', '+-àéîôù+-+'],
            ' 3. Fill with non ASCII chars'    => ['àéîôù', 10, '€', '€€àéîôù€€€'],
        ];
    }

    /**
     * @dataProvider dataReverse
     */
    public function testReverse($string, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->reverse()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataReverse()
    {
        return [
            ' 1. ' => ['àéîôù', 'ùôîéà'],
        ];
    }

    /**
     * @dataProvider dataReplaceAll
     */
    public function testReplaceAll($string, $search, $replace, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->replaceAll($search, $replace)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataReplaceAll()
    {
        return [
            ' 1. Replace one string'                              => ['abôcdñéfÑgh', 'ñ', '*', 'abôcd*éfÑgh'],
            ' 2. Replace multiple strings with same string'       => ['abôcdñéfÑgh', ['ô', 'ñ'], '*', 'ab*cd*éfÑgh'],
            ' 3. Replace multiple strings with different strings' => ['abôcdñéfÑgh', ['ô', 'ñ'], ['*', '-'], 'ab*cd-éfÑgh'],
        ];
    }

    /**
     * @dataProvider dataContains
     */
    public function testContains($string, $substring, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
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
        $result = CaseSensitiveUnicodeString::create($string)
            ->containsAny($substrings);
        $this->assertEquals($expected, $result);
    }

    public function dataContainsAny()
    {
        return [
            ' 1. String containing no substrings'                    => ['àéîôùèçâñ', ['àéè', 'îôè', 'âñè'], false],
            ' 2. String containing one substring'                    => ['àéîôùèçâñ', ['àéè', 'ôùè', 'âñè'], true],
            ' 3. String containing one substring, but not same case' => ['àéîôùèçâñ', ['àéè', 'ÔÙÈ', 'âñè'], false],
        ];
    }

    /**
     * @dataProvider dataContainsAll
     */
    public function testContainsAll($string, $substrings, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->containsAll($substrings);
        $this->assertEquals($expected, $result);
    }

    public function dataContainsAll()
    {
        return [
            ' 1. String containing no substrings'                     => ['àéîôùèçâñ', ['àéè', 'îôè', 'âñè'], false],
            ' 2. String containing one substring, but not all'        => ['àéîôùèçâñ', ['àéè', 'ôùè', 'âñè'], false],
            ' 3. String containing all substrings'                    => ['àéîôùèçâñ', ['àéî', 'ôùè', 'çâñ'], true],
            ' 4. String containing all substrings, but not same case' => ['àéîôùèçâñ', ['àéî', 'ÔÙÈ', 'çâñ'], false],
        ];
    }

    /**
     * @dataProvider dataIsSubstringOf
     */
    public function testIsSubstringOf($string, $anotherString, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->isSubstringOf($anotherString);
        $this->assertEquals($expected, $result);
    }

    public function dataIsSubstringOf()
    {
        return [
            ' 1. Is not substring'                => ['ùèù', 'àéîôùèçâñ', false],
            ' 2. Is substring'                    => ['ôùè', 'àéîôùèçâñ', true],
            ' 3. Is substring, but not same case' => ['ÔÙÈ', 'àéîôùèçâñ', false],
        ];
    }

    /**
     * @dataProvider dataIsSubstringOfAny
     */
    public function testIsSubstringOfAny($string, $strings, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->isSubstringOfAny($strings);
        $this->assertEquals($expected, $result);
    }

    public function dataIsSubstringOfAny()
    {
        return [
            ' 1. Is substring of no strings'                    => ['ôùè', ['àéîôùçâñ', 'àéçâñ', 'àùèçâñ'], false],
            ' 2. Is substring of one string'                    => ['ôùè', ['àéîôùçâñ', 'àéôùèçâñ', 'àùèçâñ'], true],
            ' 3. Is substring of one string, but not same case' => ['ôùè', ['àéîôùçâñ', 'àéçÔÙÈâñ', 'àùèçâñ'], false],
        ];
    }

    /**
     * @dataProvider dataIsSubstringOfAll
     */
    public function testIsSubstringOfAll($string, $strings, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->isSubstringOfAll($strings);
        $this->assertEquals($expected, $result);
    }

    public function dataIsSubstringOfAll()
    {
        return [
            ' 1. Is substring of no strings'                     => ['ôùè', ['àéîôùçâñ', 'àéçâñ', 'àùèçâñ'], false],
            ' 2. Is substring of one string'                     => ['ôùè', ['àéîôùçâñ', 'àéçôùèâñ', 'àùèçâñ'], false],
            ' 3. Is substring of all strings'                    => ['ôùè', ['àéîôùèçâñ', 'àéçâñôùè', 'ôùèàùèçâñ'], true],
            ' 4. Is substring of all strings, but not same case' => ['ôùè', ['àéîÔÙÈçâñ', 'àéçâñôùè', 'ôùèàùèçâñ'], false],
        ];
    }

    /**
     * @dataProvider dataIs
     */
    public function testIs($string, $otherString, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->is($otherString);
        $this->assertEquals($expected, $result);
    }

    public function dataIs()
    {
        return [
            ' 1. Same strings'                    => ['àéîÔÙÈçâñ', 'àéîÔÙÈçâñ', true],
            ' 2. Same strings but incorrect case' => ['àéîÔÙÈçâñ', 'àéîôùèçâñ', false],
        ];
    }

    /**
     * @dataProvider dataIsAny
     */
    public function testIsAny($string, $otherString, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->isAny($otherString);
        $this->assertEquals($expected, $result);
    }

    public function dataIsAny()
    {
        return [
            ' 1. Empty array of strings'             => ['àéîôù', [], false],
            ' 2. String in array'                    => ['àéîôù', ['èçâñ', 'àéîôù', 'àéîñ'], true],
            ' 3. String in array but incorrect case' => ['àéîôù', ['èçâñ', 'àéîÔÙ', 'àéîñ'], false],
            ' 4. String not in array'                => ['àéîôù', ['èçâñ', 'îôùèç', 'àéîñ'], false],
        ];
    }

    /**
     * @dataProvider dataCountOf
     */
    public function testCountOf($string, $substring, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->countOf($substring);
        $this->assertEquals($expected, $result);
    }

    public function dataCountOf()
    {
        return [
            ' 1. String containing the substring'                     => ['àéîôùèîôñ', 'îô', 2],
            ' 2. String containing the substring with different case' => ['àéîôùèÎÔñ', 'îô', 1],
        ];
    }

    /**
     * @dataProvider dataCharAt
     */
    public function testCharAt($string, $index, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->charAt($index);
        $this->assertEquals($expected, $result);
    }

    public function dataCharAt()
    {
        return [
            ' 1. ' => ['àéîôù', 1, 'é'],
        ];
    }

    /**
     * @dataProvider dataSqueeze
     */
    public function testSqueeze($string, $char, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string);
        $result = $char === NOT_PROVIDED
            ? $result->squeeze()
            : $result->squeeze($char);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataSqueeze()
    {
        return [
            ' 1. Default char'         => ['à   éî  ôù', NOT_PROVIDED, 'à éî ôù'],
            ' 2. Char given'           => ['à---éî--ôù', '-', 'à-éî-ôù'],
            ' 2. Non ASCII char given' => ['à€€€éî€€ôù', '€', 'à€éî€ôù'],
        ];
    }

    /**
     * @dataProvider dataAscii
     */
    public function testAscii($string, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->ascii()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataAscii()
    {
        return [
            ' 1. ' => ['àéîôù', 'aeiou'],
        ];
    }

    /**
     * @dataProvider dataTruncate
     */
    public function testTruncate($string, $size, $ellipsis, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string);
        $result = $ellipsis === NOT_PROVIDED
            ? $result->truncate($size)
            : $result->truncate($size, $ellipsis);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTruncate()
    {
        return [
            ' 1. Default ellipsis'                  => ['àéîôùèçâñ', 3, NOT_PROVIDED, 'àéî'],
            ' 2. Default ellipsis, string too long' => ['àéîôùèçâñ', 10, NOT_PROVIDED, 'àéîôùèçâñ'],
            ' 3. Ellipsis given'                    => ['àéîôùèçâñ', 6, '...', 'àéî...'],
        ];
    }

    /**
     * @dataProvider dataTruncateLeft
     */
    public function testTruncateLeft($string, $size, $ellipsis, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string);
        $result = $ellipsis === NOT_PROVIDED
            ? $result->truncateLeft($size)
            : $result->truncateLeft($size, $ellipsis);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTruncateLeft()
    {
        return [
            ' 1. String, default ellipsis'                  => ['àéîôùèçâñ', 3, NOT_PROVIDED, 'çâñ'],
            ' 2. String, default ellipsis, string too long' => ['àéîôùèçâñ', 10, NOT_PROVIDED, 'àéîôùèçâñ'],
            ' 3. Ellipsis given'                            => ['àéîôùèçâñ', 6, '...', '...çâñ'],
        ];
    }

    /**
     * @dataProvider dataTruncateMiddle
     */
    public function testTruncateMiddle($string, $size, $ellipsis, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string);
        $result = $ellipsis === NOT_PROVIDED
            ? $result->truncateMiddle($size)
            : $result->truncateMiddle($size, $ellipsis);
        $result = $result->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataTruncateMiddle()
    {
        return [
            ' 1. String, default ellipsis'                  => ['àéîôùèçâñ', 3, NOT_PROVIDED, 'àâñ'],
            ' 2. String, default ellipsis, string too long' => ['àéîôùèçâñ', 10, NOT_PROVIDED, 'àéîôùèçâñ'],
            ' 3. Ellipsis given'                            => ['àéîôùèçâñ', 6, '...', 'à...âñ'],
        ];
    }

    public function testReplace()
    {
        $result = CaseSensitiveUnicodeString::create('àéî')
            ->replace('çâñ');
        $this->assertEquals('çâñ', $result->toString());
        $this->assertInstanceOf(CaseSensitiveUnicodeString::class, $result);
    }

    /**
     * @dataProvider dataLines
     */
    public function testLines($string, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->lines()
            ->toArray();
        $this->assertEquals($expected, $result);
    }

    public function dataLines()
    {
        return [
            ' 1. No empty lines'              => ["àé\nîô\rùè\r\nçâ", ['àé', 'îô', 'ùè', 'çâ']],
            ' 2. Empty line at the beginning' => ["\nàé", ['', 'àé']],
            ' 3. Empty line at the end'       => ["àé\n", ['àé', '']],
            ' 3. Empty string'                => ["", ['']],
        ];
    }

    /**
     * @dataProvider dataTransform
     */
    public function testTransform($string, $callable, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->transform($callable);
        $this->assertInstanceOf(CaseSensitiveUnicodeString::class, $result);
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
     * @dataProvider dataConvert
     */
    public function testConvert($string, $callable, $expectedType, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
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
            ' 1. Result is a string' => ['àéîô', function($s) {
                    return $s->reverse();
                }, 'object', 'ôîéà'],
            ' 2. Result is an integer' => ['àéîô', function($s) {
                    return $s->length();
                }, 'integer', '4'],
        ];
    }

    /**
     * @dataProvider dataIsAcii
     */
    public function testIsAscii($string, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->isAscii();
        $this->assertEquals($expected, $result);
    }

    public function dataIsAcii()
    {
        return [
            ' 1. ASCII string'     => ['abcde', true],
            ' 2. Non ASCII string' => ['àéîôù', false],
        ];
    }

    /**
     * @dataProvider dataFill
     */
    public function testFill($size, $fill, $expected)
    {
        $result = CaseSensitiveUnicodeString::create()
            ->fill($size, $fill);
        $this->assertEquals($expected, $result);
    }

    public function dataFill()
    {
        return [
            ' 1. Fill with one char'  => [3, '*', '***'],
            ' 2. Fill with two chars' => [5, '*-', '*-*-*'],
            ' 3. Fill with non ASCII chars' => [5, '€', '€€€€€'],
        ];
    }

    /**
     * @dataProvider dataRepeatToSize
     */
    public function testRepeatToSize($string, $size, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->repeatToSize($size);
        $this->assertEquals($expected, $result);
    }

    public function dataRepeatToSize()
    {
        return [
            ' 1. Repeat one char'  => ['*', 3, '***'],
            ' 2. Repeat two chars' => ['*-', 5, '*-*-*'],
            ' 3. Repeat one non ASCII char' => ['€', 5, '€€€€€'],
        ];
    }

    /**
     * @dataProvider dataCaseTransform
     */
    public function testCaseTransform($string, $expected)
    {
        $transformer = new BasicCaseTransformer();
        $result = CaseSensitiveUnicodeString::create($string)
            ->caseTransform($transformer)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataCaseTransform()
    {
        return [
            ' 1. Separated words and digits' => ['àéî, Ôùè, 123, ÇÂÑ.', 'àéî|Ôùè|123|ÇÂÑ'],
            ' 2. Digits stuck to words'      => ['àéî123, 456Ôùè.', 'àéî|123|456|Ôùè'],
            ' 3. Words stuck together'       => ['àéîÔùè, ÇÂÑçàè', 'àéî|Ôùè|ÇÂÑ|çàè'],
        ];
    }

    /**
     * @dataProvider dataCut
     */
    public function testCut($string, $cuts, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->cut($cuts)
            ->toArray();
        $this->assertEquals($expected, $result);
    }

    public function dataCut()
    {
        return [
            ' 1. One cut'       => ['àéîôùèçâñ', 3, ['àéî', 'ôùèçâñ']],
            ' 2. Multiple cuts' => ['àéîôùèçâñ', [3, 5], ['àéî', 'ôù', 'èçâñ']],
        ];
    }

    /**
     * @dataProvider dataSplit
     */
    public function testSplit($string, $size, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string);
        $result = $size === NOT_PROVIDED
            ? $result->split()
            : $result->split($size);
        $result = $result->toArray();
        $this->assertEquals($expected, $result);
    }

    public function dataSplit()
    {
        return [
            ' 1. Default size' => ['àéîôù', NOT_PROVIDED, ['à', 'é', 'î', 'ô', 'ù']],
            ' 2. Size = 2'     => ['àéîôù', 2, ['àé', 'îô', 'ù']],
        ];
    }

    /**
     * @dataProvider dataExplode
     */
    public function testExplode($string, $delimiter, $limit, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->explode($delimiter, $limit)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataExplode()
    {
        return [
            ' 1. No limit'   => ['abôcdôéfÔgh', 'ô', PHP_INT_MAX, ['ab', 'cd', 'éfÔgh']],
            ' 2. With limit' => ['abôcdôéfÔgh', 'ô', 2, ['ab', 'cdôéfÔgh']],
        ];
    }

    /**
     * @dataProvider dataOccurences
     */
    public function testOccurences($string, $substrings, $expected)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->occurences($substrings)
            ->info([SubstringListInterface::INFO_START, SubstringListInterface::INFO_END]);
        $this->assertEquals($expected, $result);
    }

    public function dataOccurences()
    {
        return [
            ' 1. One substring with no occurences'              => ['àéîôùèÎÔù', 'ab', []],
            ' 2. One substring with occurences'                 => ['àéîôùèÎôù', 'ôù', [[3, 5], [7, 9]]],
            ' 3. One substring with occurences, different case' => ['àéîôùèÎÔù', 'ôù', [[3, 5]]],
        ];
    }

    /**
     * @dataProvider dataSeparate
     */
    public function testSeparate($string, $delimiters, $expectedSubstrings, $expectedRest)
    {
        $result = CaseSensitiveUnicodeString::create($string)
            ->separate($delimiters);
        $this->assertEquals($expectedSubstrings, $result->toArray());
        $this->assertEquals($expectedRest, $result->replace('*')->patch()->toString());
    }

    public function dataSeparate()
    {
        return [
            ' 1. Multiple delimiters' => ['1ô2é3Ô4', ['ô', 'é'], ['1', '2', '3Ô4'], '*ô*é*'],
        ];
    }

    public function testToCaseInsensitive()
    {
        $result = CaseSensitiveUnicodeString::create('àéî')
            ->toCaseInsensitive();
        $this->assertInstanceOf(CaseInsensitiveUnicodeString::class, $result);
        $this->assertEquals('àéî', $result->toString());
    }

    public function testSelect()
    {
        $result = CaseSensitiveUnicodeString::create('abc')
            ->select();
        $this->assertInstanceOf(CaseSensitiveUnicodeSubstringBuilder::class, $result);
    }

}
