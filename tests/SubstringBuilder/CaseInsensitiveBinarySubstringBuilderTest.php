<?php

use LucLeroy\Strings\CaseInsensitiveBinaryString;
use LucLeroy\Strings\SubstringBuilder\CaseInsensitiveBinarySubstringBuilder;
use PHPUnit\Framework\TestCase;

class CaseInsensitiveBinarySubstringBuilderTest extends TestCase
{

    private function makeBuilder($string, $offset)
    {
        return new CaseInsensitiveBinarySubstringBuilder(CaseInsensitiveBinaryString::create($string), $offset);
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
            ' 3. Without offset, different case' => ['0aB34ab7', 0, 'ab', [1, 8]],
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
            ' 3. Without offset, different case' => ['0ab34aB7', 0, 'ab', [5, 8]],
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
            ' 3. Without offset, different case' => ['0aB34ab7', 0, 'ab', [3, 8]],
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
            ' 3. Without offset, different case' => ['0ab34aB7', 0, 'ab', [7, 8]],
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
            ' 3. Without offset, different case' => ['*ab*0aB34ab7', 0, 'ab', [2, 7]],
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
            ' 3. Without offset, different case' => ['0ab34aB7', 0, 'ab', [0, 7]],
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
            ' 3. Without offset, different case' => ['*ab*0aB34ab7', 0, 'ab', [2, 5]],
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
            ' 3. Without offset, different case' => ['0ab34aB7', 0, 'ab', [0, 5]],
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
            ' 3. Without offset, different case' => ['0aB34ab7', 0, 'ab', [1, 3]],
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
            ' 2. Without offset, different case' => ['0ab34aB7', 0, 'ab', [5, 7]],
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
            ' 3. Without offset, different case' => ['0aB34ab7', 0, 'ab', [1, 1]],
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
            ' 3. Without offset, different case' => ['0aB34ab7', 0, 'ab', [3, 3]],
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
            ' 3. Without offset, different case' => ['0ab34aB7', 0, 'ab', [5, 5]],
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
            ' 3. Without offset, different case' => ['0ab34aB7', 0, 'ab', [7, 7]],
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
            ' 3. Without offset,  different case' => ['abcDefghij', 0, 'abcdef*hij', [0, 6]],
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
            ' 3. Without offset, different case' => ['abcdefGhij', 0, '01*defghij', [3, 10]],
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
            ' 3. Without offset, different case' => ['abcdefghij', 0, '**cdefGh**', [2, 8]],
            ' 4. With offset'                    => ['abcdefghij', 4, '**cdefgh**', [0, 4]],
        ];
    }


}
