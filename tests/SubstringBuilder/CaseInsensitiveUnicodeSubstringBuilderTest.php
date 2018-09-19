<?php

use LucLeroy\Strings\CaseInsensitiveUnicodeString;
use LucLeroy\Strings\SubstringBuilder\CaseInsensitiveUnicodeSubstringBuilder;
use PHPUnit\Framework\TestCase;

class CaseInsensitiveUnicodeSubstringBuilderTest extends TestCase
{

    private function makeBuilder($string, $offset)
    {
        return new CaseInsensitiveUnicodeSubstringBuilder(CaseInsensitiveUnicodeString::create($string), $offset);
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
            ' 1. Without offset'                 => ['0àè34àè7', 0, 'çù', null],
            ' 2. Without offset'                 => ['0àè34àè7', 0, 'àè', [1, 8]],
            ' 3. Without offset, different case' => ['0àÈ34àè7', 0, 'àè', [1, 8]],
            ' 4. With offset'                    => ['0àè34àè7', 2, 'çù', null],
            ' 5. With offset'                    => ['0àè34àè7', 2, 'àè', [3, 6]],
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
            ' 1. Without offset'                 => ['0àè34àè7', 0, 'çù', null],
            ' 2. Without offset'                 => ['0àè34àè7', 0, 'àè', [5, 8]],
            ' 3. Without offset, different case' => ['0àè34àÈ7', 0, 'àè', [5, 8]],
            ' 4. With offset'                    => ['0àè34àè7', 2, 'çù', null],
            ' 5. With offset'                    => ['0àè34àè7', 2, 'àè', [3, 6]],
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
            ' 1. Without offset'                 => ['0àè34àè7', 0, 'çù', null],
            ' 2. Without offset'                 => ['0àè34àè7', 0, 'àè', [3, 8]],
            ' 3. Without offset, different case' => ['0àÈ34àè7', 0, 'àè', [3, 8]],
            ' 4. With offset'                    => ['0àè34àè7', 2, 'çù', null],
            ' 5. With offset'                    => ['0àè34àè7', 2, 'àè', [5, 6]],
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
            ' 1. Without offset'                 => ['0àè34àè7', 0, 'çù', null],
            ' 2. Without offset'                 => ['0àè34àè7', 0, 'àè', [7, 8]],
            ' 3. Without offset, different case' => ['0àè34àÈ7', 0, 'àè', [7, 8]],
            ' 4. With offset'                    => ['0àè34àè7', 2, 'çù', null],
            ' 5. With offset'                    => ['0àè34àè7', 2, 'àè', [5, 6]],
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
            ' 1. Without offset'                 => ['*àè*0àè34àè7', 2, 'çù', null],
            ' 2. Without offset'                 => ['*àè*0àè34àè7', 0, 'àè', [2, 7]],
            ' 3. Without offset, different case' => ['*àè*0àÈ34àè7', 0, 'àè', [2, 7]],
            ' 4. With offset'                    => ['*àè*0àè34àè7', 2, 'çù', null],
            ' 5. With offset'                    => ['*àè*0àè34àè7', 2, 'àè', [2, 5]],
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
            ' 1. Without offset'                 => ['0àè34àè7', 0, 'çù', null],
            ' 2. Without offset'                 => ['0àè34àè7', 0, 'àè', [0, 7]],
            ' 3. Without offset, different case' => ['0àè34àÈ7', 0, 'àè', [0, 7]],
            ' 4. With offset'                    => ['0àè34àè7', 2, 'çù', null],
            ' 5. With offset'                    => ['0àè34àè7', 2, 'àè', [0, 5]],
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
            ' 1. Without offset'                 => ['*àè*0àè34àè7', 2, 'çù', null],
            ' 2. Without offset'                 => ['*àè*0àè34àè7', 0, 'àè', [2, 5]],
            ' 3. Without offset, different case' => ['*àè*0àÈ34àè7', 0, 'àè', [2, 5]],
            ' 4. With offset'                    => ['*àè*0àè34àè7', 2, 'çù', null],
            ' 5. With offset'                    => ['*àè*0àè34àè7', 2, 'àè', [2, 3]],
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
            ' 1. Without offset'                 => ['0àè34àè7', 0, 'çù', null],
            ' 2. Without offset'                 => ['0àè34àè7', 0, 'àè', [0, 5]],
            ' 3. Without offset, different case' => ['0àè34àÈ7', 0, 'àè', [0, 5]],
            ' 4. With offset'                    => ['0àè34àè7', 2, 'çù', null],
            ' 5. With offset'                    => ['0àè34àè7', 2, 'àè', [0, 3]],
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
            ' 1. Without offset'                 => ['0àè34àè7', 0, 'çù', null],
            ' 2. Without offset'                 => ['0àè34àè7', 0, 'àè', [1, 3]],
            ' 3. Without offset, different case' => ['0àÈ34àè7', 0, 'àè', [1, 3]],
            ' 4. With offset'                    => ['0àè34àè7', 2, 'çù', null],
            ' 5. With offset'                    => ['0àè34àè7', 2, 'àè', [3, 5]],
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
            ' 1. Without offset'                 => ['0àè34àè7', 0, 'çù', null],
            ' 2. Without offset'                 => ['0àè34àè7', 0, 'àè', [5, 7]],
            ' 2. Without offset, different case' => ['0àè34àÈ7', 0, 'àè', [5, 7]],
            ' 3. With offset'                    => ['0àè34àè7', 2, 'çù', null],
            ' 4. With offset'                    => ['0àè34àè7', 2, 'àè', [3, 5]],
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
            ' 1. Without offset'                 => ['0àè34àè7', 0, 'çù', null],
            ' 2. Without offset'                 => ['0àè34àè7', 0, 'àè', [1, 1]],
            ' 3. Without offset, different case' => ['0àÈ34àè7', 0, 'àè', [1, 1]],
            ' 4. With offset'                    => ['0àè34àè7', 2, 'çù', null],
            ' 5. With offset'                    => ['0àè34àè7', 2, 'àè', [3, 3]],
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
            ' 1. Without offset'                 => ['0àè34àè7', 0, 'çù', null],
            ' 2. Without offset'                 => ['0àè34àè7', 0, 'àè', [3, 3]],
            ' 3. Without offset, different case' => ['0àÈ34àè7', 0, 'àè', [3, 3]],
            ' 4. With offset'                    => ['0àè34àè7', 2, 'çù', null],
            ' 5. With offset'                    => ['0àè34àè7', 2, 'àè', [5, 5]],
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
            ' 1. Without offset'                 => ['0àè34àè7', 0, 'çù', null],
            ' 2. Without offset'                 => ['0àè34àè7', 0, 'àè', [5, 5]],
            ' 3. Without offset, different case' => ['0àè34àÈ7', 0, 'àè', [5, 5]],
            ' 4. With offset'                    => ['0àè34àè7', 2, 'çù', null],
            ' 5. With offset'                    => ['0àè34àè7', 2, 'àè', [3, 3]],
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
            ' 1. Without offset'                 => ['0àè34àè7', 0, 'çù', null],
            ' 2. Without offset'                 => ['0àè34àè7', 0, 'àè', [7, 7]],
            ' 3. Without offset, different case' => ['0àè34àÈ7', 0, 'àè', [7, 7]],
            ' 4. With offset'                    => ['0àè34àè7', 2, 'çù', null],
            ' 5. With offset'                    => ['0àè34àè7', 2, 'àè', [5, 5]],
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
            ' 1. Without offset, not matching' => ['àèçùéôñâëî', 0, '(', ')', false, null],
            ' 2. Without offset, not matching' => ['àè(çùé(ôñ)âëî', 0, '(', ')', false, [2, 10]],
            ' 3. Without offset, not matching' => ['àè(çùé(ôñ)â)ëî', 0, '(', ')', false, [2, 10]],
            ' 4. With offset, not matching'    => ['àèçùéôñâëî', 2, '(', ')', false, null],
            ' 5. With offset, not matching'    => ['àè(çùé(ôñ)â)ëî', 3, '(', ')', false, [3, 7]],
            ' 6. Without offset, matching'     => ['àèçùéôñâëî', 0, '(', ')', true, null],
            ' 7. Without offset, matching'     => ['àè(çùé(ôñ)âëî', 0, '(', ')', true, [6, 10]],
            ' 8. Without offset, matching'     => ['àè(çùé(ôñ)â)ëî', 0, '(', ')', true, [2, 12]],
            ' 9. With offset, matching'        => ['àèçùéôñâëî', 2, '(', ')', true, null],
            '10. With offset, matching'        => ['àè(çùé(ôñ)â)ëî', 3, '(', ')', true, [3, 7]],
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
            ' 1. Without offset, not matching' => ['àèçùéôñâëî', 0, '(', ')', false, null],
            ' 2. Without offset, not matching' => ['àè(çùé(ôñ)âëî', 0, '(', ')', false, [3, 9]],
            ' 3. Without offset, not matching' => ['àè(çùé(ôñ)â)ëî', 0, '(', ')', false, [3, 9]],
            ' 4. With offset, not matching'    => ['àèçùéôñâëî', 2, '(', ')', false, null],
            ' 5. With offset, not matching'    => ['àè(çùé(ôñ)â)ëî', 3, '(', ')', false, [4, 6]],
            ' 6. Without offset'               => ['àèçùéôñâëî', 0, '(', ')', true, null],
            ' 7. Without offset'               => ['àè(çùé(ôñ)âëî', 0, '(', ')', true, [7, 9]],
            ' 8. Without offset'               => ['àè(çùé(ôñ)â)ëî', 0, '(', ')', true, [3, 11]],
            ' 9. With offset'                  => ['àèçùéôñâëî', 2, '(', ')', true, null],
            '10. With offset'                  => ['àè(çùé(ôñ)â)ëî', 3, '(', ')', true, [4, 6]],
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
            ' 1. Without offset'                  => ['àèçùéôñâëî', 0, '*èçùéôñâëî', [0, 0]],
            ' 2. Without offset'                  => ['àèçùéôñâëî', 0, 'àèçùéô*âëî', [0, 6]],
            ' 3. Without offset,  different case' => ['àèçÙéôñâëî', 0, 'àèçùéô*âëî', [0, 6]],
            ' 4. With offset'                     => ['àèçùéôñâëî', 4, 'àèçùéôñâëî', [0, 0]],
            ' 5. With offset'                     => ['àèçùéôñâëî', 4, 'éô*âëî', [0, 2]],
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
            ' 1. Without offset'                 => ['àèçùéôñâëî', 0, 'àèçùéôñâë*', [10, 10]],
            ' 2. Without offset'                 => ['àèçùéôñâëî', 0, 'àè*ùéôñâëî', [3, 10]],
            ' 3. Without offset, different case' => ['àèçùéôÑâëî', 0, 'àè*ùéôñâëî', [3, 10]],
            ' 4. With offset'                    => ['àèçùéôñâëî', 4, 'àè*ùéôñâëî', [0, 6]],
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
            ' 1. Without offset'                 => ['àèçùéôñâëî', 0, '**çùéôñâ**', [2, 8]],
            ' 2. Without offset'                 => ['àèçùéôñâëî', 0, 'klmnopqrst', [0, 0]],
            ' 2. Without offset, different case' => ['àèçùéôñâëî', 0, '**çùéôÑâ**', [2, 8]],
            ' 3. With offset'                    => ['àèçùéôñâëî', 4, '**çùéôñâ**', [0, 4]],
        ];
    }

}
