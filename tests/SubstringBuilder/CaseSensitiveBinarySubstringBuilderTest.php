<?php

use LucLeroy\Strings\CaseSensitiveBinaryString;
use LucLeroy\Strings\SubstringBuilder\CaseSensitiveBinarySubstringBuilder;
use PHPUnit\Framework\TestCase;

class CaseSensitiveBinarySubstringBuilderTest extends TestCase
{

    private function makeBuilder($string, $offset)
    {
        return new CaseSensitiveBinarySubstringBuilder(CaseSensitiveBinaryString::create($string), $offset);
    }

    /**
     * @dataProvider dataFrom
     */
    public function testFrom($string, $offset, $index, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from($index)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataFrom()
    {
        return [
            ' 1. Without offset' => ['abcdefgh', 0, 0, [0, 8]],
            ' 2. Without offset' => ['abcdefgh', 0, 2, [2, 8]],
            ' 3. Without offset' => ['abcdefgh', 0, -5, [3, 8]],
            ' 4. With offset'    => ['abcdefgh', 2, 0, [0, 6]],
            ' 5. With offset'    => ['abcdefgh', 2, 2, [2, 6]],
            ' 6. With offset'    => ['abcdefgh', 2, -5, [1, 6]],
        ];
    }

    /**
     * @dataProvider dataAfter
     */
    public function testAfter($string, $offset, $index, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->after($index)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataAfter()
    {
        return [
            ' 1. Without offset' => ['abcdefgh', 0, 0, [1, 8]],
            ' 2. Without offset' => ['abcdefgh', 0, 2, [3, 8]],
            ' 3. Without offset' => ['abcdefgh', 0, -5, [4, 8]],
            ' 4. With offset'    => ['abcdefgh', 2, 0, [1, 6]],
            ' 5. With offset'    => ['abcdefgh', 2, 2, [3, 6]],
            ' 6. With offset'    => ['abcdefgh', 2, -5, [2, 6]],
        ];
    }

    /**
     * @dataProvider dataTo
     */
    public function testTo($string, $offset, $index, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->to($index)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataTo()
    {
        return [
            ' 1. Without offset' => ['abcdefgh', 0, 0, [0, 1]],
            ' 2. Without offset' => ['abcdefgh', 0, 5, [0, 6]],
            ' 3. Without offset' => ['abcdefgh', 0, -2, [0, 7]],
            ' 4. With offset'    => ['abcdefgh', 2, 0, [0, 1]],
            ' 5. With offset'    => ['abcdefgh', 2, 5, [0, 6]],
            ' 6. With offset'    => ['abcdefgh', 2, -2, [0, 5]],
        ];
    }

    /**
     * @dataProvider dataBefore
     */
    public function testBefore($string, $offset, $index, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->before($index)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataBefore()
    {
        return [
            ' 1. Without offset' => ['abcdefgh', 0, 0, [0, 0]],
            ' 2. Without offset' => ['abcdefgh', 0, 5, [0, 5]],
            ' 3. Without offset' => ['abcdefgh', 0, -2, [0, 6]],
            ' 4. With offset'    => ['abcdefgh', 2, 0, [0, 0]],
            ' 5. With offset'    => ['abcdefgh', 2, 5, [0, 5]],
            ' 6. With offset'    => ['abcdefgh', 2, -2, [0, 4]],
        ];
    }

    /**
     * @dataProvider dataAt
     */
    public function testAt($string, $offset, $index, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->at($index)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataAt()
    {
        return [
            ' 1. Without offset' => ['abcdefgh', 0, 0, [0, 0]],
            ' 2. Without offset' => ['abcdefgh', 0, 5, [5, 5]],
            ' 3. Without offset' => ['abcdefgh', 0, -2, [6, 6]],
            ' 4. With offset'    => ['abcdefgh', 2, 0, [0, 0]],
            ' 5. With offset'    => ['abcdefgh', 2, 5, [5, 5]],
            ' 6. With offset'    => ['abcdefgh', 2, -2, [4, 4]],
        ];
    }

    /**
     * @dataProvider dataFromFirst
     */
    public function testFromFirst($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->fromFirst($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataFromFirst()
    {
        return [
            ' 1. Without offset'                 => ['0ab34ab7', 0, 'cd', null],
            ' 2. Without offset'                 => ['0ab34ab7', 0, 'ab', [1, 8]],
            ' 3. Without offset, different case' => ['0aB34ab7', 0, 'ab', [5, 8]],
            ' 4. With offset'                    => ['0ab34ab7', 2, 'cd', null],
            ' 5. With offset'                    => ['0ab34ab7', 2, 'ab', [3, 6]],
        ];
    }

    /**
     * @dataProvider dataFromLast
     */
    public function testFromLast($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->fromLast($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataFromLast()
    {
        return [
            ' 1. Without offset'                 => ['0ab34ab7', 0, 'cd', null],
            ' 2. Without offset'                 => ['0ab34ab7', 0, 'ab', [5, 8]],
            ' 3. Without offset, different case' => ['0ab34aB7', 0, 'ab', [1, 8]],
            ' 4. With offset'                    => ['0ab34ab7', 2, 'cd', null],
            ' 5. With offset'                    => ['0ab34ab7', 2, 'ab', [3, 6]],
        ];
    }

    /**
     * @dataProvider dataAfterFirst
     */
    public function testAfterFirst($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->afterFirst($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataAfterFirst()
    {
        return [
            ' 1. Without offset'                 => ['0ab34ab7', 0, 'cd', null],
            ' 2. Without offset'                 => ['0ab34ab7', 0, 'ab', [3, 8]],
            ' 3. Without offset, different case' => ['0aB34ab7', 0, 'ab', [7, 8]],
            ' 4. With offset'                    => ['0ab34ab7', 2, 'cd', null],
            ' 5. With offset'                    => ['0ab34ab7', 2, 'ab', [5, 6]],
        ];
    }

    /**
     * @dataProvider dataAfterLast
     */
    public function testAfterLast($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->afterLast($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataAfterLast()
    {
        return [
            ' 1. Without offset'                 => ['0ab34ab7', 0, 'cd', null],
            ' 2. Without offset'                 => ['0ab34ab7', 0, 'ab', [7, 8]],
            ' 3. Without offset, different case' => ['0ab34aB7', 0, 'ab', [3, 8]],
            ' 4. With offset'                    => ['0ab34ab7', 2, 'cd', null],
            ' 5. With offset'                    => ['0ab34ab7', 2, 'ab', [5, 6]],
        ];
    }

    /**
     * @dataProvider dataToNext
     */
    public function testToNext($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from(2)
            ->toNext($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataToNext()
    {
        return [
            ' 1. Without offset'                 => ['*ab*0ab34ab7', 2, 'cd', null],
            ' 2. Without offset'                 => ['*ab*0ab34ab7', 0, 'ab', [2, 7]],
            ' 3. Without offset, different case' => ['*ab*0aB34ab7', 0, 'ab', [2, 11]],
            ' 4. With offset'                    => ['*ab*0ab34ab7', 2, 'cd', null],
            ' 5. With offset'                    => ['*ab*0ab34ab7', 2, 'ab', [2, 5]],
        ];
    }

    /**
     * @dataProvider dataToLast
     */
    public function testToLast($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->toLast($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataToLast()
    {
        return [
            ' 1. Without offset'                 => ['0ab34ab7', 0, 'cd', null],
            ' 2. Without offset'                 => ['0ab34ab7', 0, 'ab', [0, 7]],
            ' 3. Without offset, different case' => ['0ab34aB7', 0, 'ab', [0, 3]],
            ' 4. With offset'                    => ['0ab34ab7', 2, 'cd', null],
            ' 5. With offset'                    => ['0ab34ab7', 2, 'ab', [0, 5]],
        ];
    }

    /**
     * @dataProvider dataBeforeNext
     */
    public function testBeforeNext($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from(2)
            ->beforeNext($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataBeforeNext()
    {
        return [
            ' 1. Without offset'                 => ['*ab*0ab34ab7', 2, 'cd', null],
            ' 2. Without offset'                 => ['*ab*0ab34ab7', 0, 'ab', [2, 5]],
            ' 3. Without offset, different case' => ['*ab*0aB34ab7', 0, 'ab', [2, 9]],
            ' 4. With offset'                    => ['*ab*0ab34ab7', 2, 'cd', null],
            ' 5. With offset'                    => ['*ab*0ab34ab7', 2, 'ab', [2, 3]],
        ];
    }

    /**
     * @dataProvider dataBeforeLast
     */
    public function testBeforeLast($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->beforeLast($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataBeforeLast()
    {
        return [
            ' 1. Without offset'                 => ['0ab34ab7', 0, 'cd', null],
            ' 2. Without offset'                 => ['0ab34ab7', 0, 'ab', [0, 5]],
            ' 3. Without offset, different case' => ['0ab34aB7', 0, 'ab', [0, 1]],
            ' 4. With offset'                    => ['0ab34ab7', 2, 'cd', null],
            ' 5. With offset'                    => ['0ab34ab7', 2, 'ab', [0, 3]],
        ];
    }

    /**
     * @dataProvider dataFirst
     */
    public function testFirst($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->first($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataFirst()
    {
        return [
            ' 1. Without offset'                 => ['0ab34ab7', 0, 'cd', null],
            ' 2. Without offset'                 => ['0ab34ab7', 0, 'ab', [1, 3]],
            ' 3. Without offset, different case' => ['0aB34ab7', 0, 'ab', [5, 7]],
            ' 4. With offset'                    => ['0ab34ab7', 2, 'cd', null],
            ' 5. With offset'                    => ['0ab34ab7', 2, 'ab', [3, 5]],
        ];
    }

    /**
     * @dataProvider dataLast
     */
    public function testLast($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->last($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataLast()
    {
        return [
            ' 1. Without offset'                 => ['0ab34ab7', 0, 'cd', null],
            ' 2. Without offset'                 => ['0ab34ab7', 0, 'ab', [5, 7]],
            ' 2. Without offset, different case' => ['0ab34aB7', 0, 'ab', [1, 3]],
            ' 3. With offset'                    => ['0ab34ab7', 2, 'cd', null],
            ' 4. With offset'                    => ['0ab34ab7', 2, 'ab', [3, 5]],
        ];
    }

    /**
     * @dataProvider dataAtStartOfFirst
     */
    public function testAtStartOfFirst($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->atStartOfFirst($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataAtStartOfFirst()
    {
        return [
            ' 1. Without offset'                 => ['0ab34ab7', 0, 'cd', null],
            ' 2. Without offset'                 => ['0ab34ab7', 0, 'ab', [1, 1]],
            ' 3. Without offset, different case' => ['0aB34ab7', 0, 'ab', [5, 5]],
            ' 4. With offset'                    => ['0ab34ab7', 2, 'cd', null],
            ' 5. With offset'                    => ['0ab34ab7', 2, 'ab', [3, 3]],
        ];
    }

    /**
     * @dataProvider dataAtEndOfFirst
     */
    public function testAtEndOfFirst($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->atEndOfFirst($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataAtEndOfFirst()
    {
        return [
            ' 1. Without offset'                 => ['0ab34ab7', 0, 'cd', null],
            ' 2. Without offset'                 => ['0ab34ab7', 0, 'ab', [3, 3]],
            ' 3. Without offset, different case' => ['0aB34ab7', 0, 'ab', [7, 7]],
            ' 4. With offset'                    => ['0ab34ab7', 2, 'cd', null],
            ' 5. With offset'                    => ['0ab34ab7', 2, 'ab', [5, 5]],
        ];
    }

    /**
     * @dataProvider dataAtStartOfLast
     */
    public function testAtStartOfLast($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->atStartOfLast($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataAtStartOfLast()
    {
        return [
            ' 1. Without offset'                 => ['0ab34ab7', 0, 'cd', null],
            ' 2. Without offset'                 => ['0ab34ab7', 0, 'ab', [5, 5]],
            ' 3. Without offset, different case' => ['0ab34aB7', 0, 'ab', [1, 1]],
            ' 4. With offset'                    => ['0ab34ab7', 2, 'cd', null],
            ' 5. With offset'                    => ['0ab34ab7', 2, 'ab', [3, 3]],
        ];
    }

    /**
     * @dataProvider dataAtEndOfLast
     */
    public function testAtEndOfLast($string, $offset, $substring, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->atEndOfLast($substring)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataAtEndOfLast()
    {
        return [
            ' 1. Without offset'                 => ['0ab34ab7', 0, 'cd', null],
            ' 2. Without offset'                 => ['0ab34ab7', 0, 'ab', [7, 7]],
            ' 3. Without offset, different case' => ['0ab34aB7', 0, 'ab', [3, 3]],
            ' 4. With offset'                    => ['0ab34ab7', 2, 'cd', null],
            ' 5. With offset'                    => ['0ab34ab7', 2, 'ab', [5, 5]],
        ];
    }

    /**
     * @dataProvider dataBetweenSubstrings
     */
    public function testBetweenSubstrings($string, $offset, $open, $close, $match, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->betweenSubstrings($open, $close, $match)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataBetweenSubstrings()
    {
        return [
            ' 1. Without offset, not matching' => ['abcdefghij', 0, '(', ')', false, null],
            ' 2. Without offset, not matching' => ['ab(cde(fg)hij', 0, '(', ')', false, [2, 10]],
            ' 3. Without offset, not matching' => ['ab(cde(fg)h)ij', 0, '(', ')', false, [2, 10]],
            ' 4. With offset, not matching'    => ['abcdefghij', 2, '(', ')', false, null],
            ' 5. With offset, not matching'    => ['ab(cde(fg)h)ij', 3, '(', ')', false, [3, 7]],
            ' 6. Without offset, matching'     => ['abcdefghij', 0, '(', ')', true, null],
            ' 7. Without offset, matching'     => ['ab(cde(fg)hij', 0, '(', ')', true, [6, 10]],
            ' 8. Without offset, matching'     => ['ab(cde(fg)h)ij', 0, '(', ')', true, [2, 12]],
            ' 9. With offset, matching'        => ['abcdefghij', 2, '(', ')', true, null],
            '10. With offset, matching'        => ['ab(cde(fg)h)ij', 3, '(', ')', true, [3, 7]],
        ];
    }

    /**
     * @dataProvider dataInsideSubstrings
     */
    public function testInsideSubstrings($string, $offset, $open, $close, $match, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->insideSubstrings($open, $close, $match)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataInsideSubstrings()
    {
        return [
            ' 1. Without offset, not matching' => ['abcdefghij', 0, '(', ')', false, null],
            ' 2. Without offset, not matching' => ['ab(cde(fg)hij', 0, '(', ')', false, [3, 9]],
            ' 3. Without offset, not matching' => ['ab(cde(fg)h)ij', 0, '(', ')', false, [3, 9]],
            ' 4. With offset, not matching'    => ['abcdefghij', 2, '(', ')', false, null],
            ' 5. With offset, not matching'    => ['ab(cde(fg)h)ij', 3, '(', ')', false, [4, 6]],
            ' 6. Without offset'               => ['abcdefghij', 0, '(', ')', true, null],
            ' 7. Without offset'               => ['ab(cde(fg)hij', 0, '(', ')', true, [7, 9]],
            ' 8. Without offset'               => ['ab(cde(fg)h)ij', 0, '(', ')', true, [3, 11]],
            ' 9. With offset'                  => ['abcdefghij', 2, '(', ')', true, null],
            '10. With offset'                  => ['ab(cde(fg)h)ij', 3, '(', ')', true, [4, 6]],
        ];
    }

    /**
     * @dataProvider dataLongestCommonPrefix
     */
    public function testLongestCommonPrefix($string, $offset, $otherString, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->longestCommonPrefix($otherString)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataLongestCommonPrefix()
    {
        return [
            ' 1. Without offset'                  => ['abcdefghij', 0, '*bcdefghij', [0, 0]],
            ' 2. Without offset'                  => ['abcdefghij', 0, 'abcdef*hij', [0, 6]],
            ' 3. Without offset,  different case' => ['abcDefghij', 0, 'abcdef*hij', [0, 3]],
            ' 4. With offset'                     => ['abcdefghij', 4, 'abcdefghij', [0, 0]],
            ' 5. With offset'                     => ['abcdefghij', 4, 'ef*hij', [0, 2]],
        ];
    }

    /**
     * @dataProvider dataLongestCommonSuffix
     */
    public function testLongestCommonSuffix($string, $offset, $otherString, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->longestCommonSuffix($otherString)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataLongestCommonSuffix()
    {
        return [
            ' 1. Without offset'                 => ['abcdefghij', 0, 'abcdefghi*', [10, 10]],
            ' 2. Without offset'                 => ['abcdefghij', 0, '01*defghij', [3, 10]],
            ' 3. Without offset, different case' => ['abcdefGhij', 0, '01*defghij', [7, 10]],
            ' 4. With offset'                    => ['abcdefghij', 4, 'ab*defghij', [0, 6]],
        ];
    }

    /**
     * @dataProvider dataLongestCommonSubstring
     */
    public function testLongestCommonSubstring($string, $offset, $otherString, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->longestCommonSubstring($otherString)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataLongestCommonSubstring()
    {
        return [
            ' 1. Without offset'                 => ['abcdefghij', 0, '**cdefgh**', [2, 8]],
            ' 2. Without offset'                 => ['abcdefghij', 0, 'klmnopqrst', [0, 0]],
            ' 2. Without offset, different case' => ['abcdefghij', 0, '**cdefGh**', [2, 6]],
            ' 3. With offset'                    => ['abcdefghij', 4, '**cdefgh**', [0, 4]],
        ];
    }

    /**
     * @dataProvider dataShiftLeft
     */
    public function testShiftLeft($string, $offset, $from, $to, $shift, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from($from)
            ->to($to)
            ->shiftLeft($shift)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataShiftLeft()
    {
        return [
            ' 1. Without offset' => ['abcdefghij', 0, 1, 5, 0, [1, 6]],
            ' 2. Without offset' => ['abcdefghij', 0, 1, 5, -1, [0, 6]],
            ' 3. Without offset' => ['abcdefghij', 0, 1, 5, -2, [-1, 6]],
            ' 4. Without offset' => ['abcdefghij', 0, 4, 5, 2, [6, 6]],
            ' 5. Without offset' => ['abcdefghij', 0, 4, 5, 3, null],
        ];
    }

    /**
     * @dataProvider dataShiftRight
     */
    public function testShiftRight($string, $offset, $from, $to, $shift, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from($from)
            ->to($to)
            ->shiftRight($shift)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataShiftRight()
    {
        return [
            ' 1. Without offset' => ['abcdefghij', 0, 5, 9, 0, [5, 10]],
            ' 2. Without offset' => ['abcdefghij', 0, 5, 9, 1, [5, 11]],
            ' 3. Without offset' => ['abcdefghij', 0, 5, 9, -2, [5, 8]],
            ' 4. Without offset' => ['abcdefghij', 0, 5, 9, -5, [5, 5]],
            ' 5. Without offset' => ['abcdefghij', 0, 5, 9, -6, null],
        ];
    }

    /**
     * @dataProvider dataGrow
     */
    public function testGrow($string, $offset, $from, $to, $shift, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from($from)
            ->to($to)
            ->grow($shift)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataGrow()
    {
        return [
            ' 1. Without offset' => ['abcdefghij', 0, 2, 6, 1, [1, 8]],
        ];
    }

    /**
     * @dataProvider dataShrink
     */
    public function testShrink($string, $offset, $from, $to, $shift, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from($from)
            ->to($to)
            ->shrink($shift)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataShrink()
    {
        return [
            ' 1. Without offset' => ['abcdefghij', 0, 2, 6, 1, [3, 6]],
        ];
    }

    public function testFromLeft()
    {
        $result = $this->makeBuilder('abcdefghij', 0)
            ->from(5)
            ->fromLeft()
            ->selection();
        $this->assertEquals([0, 10], $result);
    }

    public function testToRight()
    {
        $result = $this->makeBuilder('abcdefghij', 0)
            ->to(5)
            ->toRight()
            ->selection();
        $this->assertEquals([0, 10], $result);
    }

    /**
     * @dataProvider dataStart
     */
    public function testStart($string, $offset, $from, $to, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from($from)
            ->to($to)
            ->start();
        $this->assertEquals($expected, $result);
    }

    public function dataStart()
    {
        return [
            ' 1. Without offset' => ['abcdefghij', 0, 3, 5, 3],
            ' 2. With offset'    => ['abcdefghij', 2, 3, 5, 3],
        ];
    }

    /**
     * @dataProvider dataEnd
     */
    public function testEnd($string, $offset, $from, $to, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from($from)
            ->to($to)
            ->end();
        $this->assertEquals($expected, $result);
    }

    public function dataEnd()
    {
        return [
            ' 1. Without offset' => ['abcdefghij', 0, 3, 5, 6],
            ' 2. With offset'    => ['abcdefghij', 2, 3, 5, 6],
        ];
    }

    /**
     * @dataProvider dataLength
     */
    public function testLength($string, $offset, $from, $to, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from($from)
            ->to($to)
            ->length();
        $this->assertEquals($expected, $result);
    }

    public function dataLength()
    {
        return [
            ' 1. Without offset' => ['abcdefghij', 0, 3, 5, 3],
            ' 2. With offset'    => ['abcdefghij', 2, 3, 5, 3],
        ];
    }

    /**
     * @dataProvider dataIsEmpty
     */
    public function testIsEmpty($string, $offset, $from, $to, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from($from)
            ->to($to)
            ->isEmpty();
        $this->assertEquals($expected, $result);
    }

    public function dataIsEmpty()
    {
        return [
            ' 1. Without offset' => ['abcdefghij', 0, 3, 5, false],
            ' 2. Without offset' => ['abcdefghij', 0, 3, 3, false],
            ' 3. Without offset' => ['abcdefghij', 0, 5, 3, true],
        ];
    }

    /**
     * @dataProvider dataToString
     */
    public function testToString($string, $offset, $from, $to, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from($from)
            ->to($to)
            ->toString();
        $this->assertEquals('string', gettype($result));
        $this->assertEquals($expected, $result);
    }

    public function dataToString()
    {
        return [
            ' 1. Without offset' => ['abcdefghij', 0, 3, 5, 'def'],
            ' 2. Without offset' => ['abcdefghij', 0, 3, 3, 'd'],
            ' 3. Without offset' => ['abcdefghij', 0, 5, 3, ''],
        ];
    }

    /**
     * @dataProvider dataRemove
     */
    public function testRemove($string, $offset, $from, $to, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from($from)
            ->to($to)
            ->remove()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataRemove()
    {
        return [
            ' 1. Without offset' => ['abcdefghij', 0, 3, 5, 'abcghij'],
            ' 2. Without offset' => ['abcdefghij', 0, 3, 3, 'abcefghij'],
            ' 3. Without offset' => ['abcdefghij', 0, 5, 3, 'abcdefghij'],
        ];
    }

    /**
     * @dataProvider dataPatch
     */
    public function testPatch($string, $offset, $from, $to, $patch, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from($from)
            ->to($to)
            ->patch($patch)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataPatch()
    {
        return [
            ' 1. Without offset' => ['abcdefghij', 0, 3, 5, '*', 'abc*ghij'],
            ' 2. Without offset' => ['abcdefghij', 0, 3, 3, '*', 'abc*efghij'],
            ' 3. Without offset' => ['abcdefghij', 0, 5, 3, '*', 'abcdefghij'],
            ' 4. With offset'    => ['abcdefghij', 2, 3, 5, '*', 'abcde*ij'],
            ' 5. With offset'    => ['abcdefghij', 2, 3, 3, '*', 'abcde*ghij'],
            ' 6. With offset'    => ['abcdefghij', 2, 5, 3, '*', 'abcdefghij'],
        ];
    }
    
    /**
     * @dataProvider dataToLength
     */
    public function testToLength($string, $offset, $from, $length, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->from($from)
            ->toLength($length)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataToLength()
    {
        return [
            ' 1. Without offset' => ['abcdefgh', 0, 2, 3, [2, 5]],
        ];
    }
    
    /**
     * @dataProvider dataFromLength
     */
    public function testFromLength($string, $offset, $to, $length, $expected)
    {
        $result = $this->makeBuilder($string, $offset)
            ->to($to)
            ->fromLength($length)
            ->selection();
        $this->assertEquals($expected, $result);
    }

    public function dataFromLength()
    {
        return [
            ' 1. Without offset' => ['abcdefgh', 0, 6, 3, [4, 7]],
        ];
    }

}
