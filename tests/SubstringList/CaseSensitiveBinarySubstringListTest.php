<?php

use LucLeroy\Strings\CaseSensitiveBinaryString;
use LucLeroy\Strings\SubstringList\CaseSensitiveBinarySubstringList;
use LucLeroy\Strings\SubstringList\SubstringInfo;
use PHPUnit\Framework\TestCase;

class CaseSensitiveBinarySubstringListTest extends TestCase
{

    /**
     * 
     * @param array $substrings
     * @return CaseSensitiveBinarySubstringList
     */
    private function makeSubstringList($substrings)
    {
        return CaseSensitiveBinarySubstringList::create($substrings, CaseSensitiveBinaryString::create(implode('', $substrings)));
    }

    /**
     * 
     * @dataProvider dataToArray
     */
    public function testToArray($substrings, $expected)
    {
        $result = $this->makeSubstringList($substrings)
            ->toArray();
        $this->assertInstanceOf(CaseSensitiveBinaryString::class, $result[0]);
        $this->assertEquals($expected, $result);
    }

    public function dataToArray()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], ['cd', 'gh', 'kl']]
        ];
    }

    /**
     * 
     * @dataProvider dataImplode
     */
    public function testImplode($substrings, $separator, $expected)
    {
        $result = $this->makeSubstringList($substrings)
            ->implode($separator)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataImplode()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], ',', 'cd,gh,kl']
        ];
    }

    /**
     * 
     * @dataProvider dataPatch
     */
    public function testPatch($substrings, $replace, $expected)
    {
        $result = $this->makeSubstringList($substrings)
            ->replace($replace)
            ->patch()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataPatch()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], '**', 'ab**ef**ij**mn']
        ];
    }

    /**
     * 
     * @dataProvider dataReverse
     */
    public function testReverse($substrings, $expected)
    {
        $result = $this->makeSubstringList($substrings)
            ->reverse()
            ->toArray();
        $this->assertInstanceOf(CaseSensitiveBinaryString::class, $result[0]);
        $this->assertEquals($expected, $result);
    }

    public function dataReverse()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], ['dc', 'hg', 'lk']]
        ];
    }

    /**
     * 
     * @dataProvider dataCount
     */
    public function testCount($substrings, $expected)
    {
        $result = $this->makeSubstringList($substrings)
            ->count();
        $this->assertEquals($expected, $result);
    }

    public function dataCount()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], 3]
        ];
    }

    /**
     * 
     * @dataProvider dataRemove
     */
    public function testRemove($substrings, $expected)
    {
        $result = $this->makeSubstringList($substrings)
            ->remove()
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataRemove()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], 'abefijmn']
        ];
    }

    /**
     * 
     * @dataProvider dataSubstringAt
     */
    public function testSubstringAt($substrings, $index, $expected)
    {
        $result = $this->makeSubstringList($substrings)
            ->substringAt($index)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataSubstringAt()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], 0, 'cd']
        ];
    }

    /**
     * 
     * @dataProvider dataBeforeSubstringAt
     */
    public function testBeforeSubstringAt($substrings, $index, $expected)
    {
        $result = $this->makeSubstringList($substrings)
            ->beforeSubstringAt($index)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataBeforeSubstringAt()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], 0, 'ab']
        ];
    }

    /**
     * 
     * @dataProvider dataAfterSubstringAt
     */
    public function testAfterSubstringAt($substrings, $index, $expected)
    {
        $result = $this->makeSubstringList($substrings)
            ->afterSubstringAt($index)
            ->toString();
        $this->assertEquals($expected, $result);
    }

    public function dataAfterSubstringAt()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], 0, 'ef']
        ];
    }

    /**
     * 
     * @dataProvider dataStart
     */
    public function testStart($substrings, $expected)
    {
        $result = $this->makeSubstringList($substrings)
            ->start();
        $this->assertEquals($expected, $result);
    }

    public function dataStart()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], [2, 6, 10]]
        ];
    }

    /**
     * 
     * @dataProvider dataEnd
     */
    public function testEnd($substrings, $expected)
    {
        $result = $this->makeSubstringList($substrings)
            ->end();
        $this->assertEquals($expected, $result);
    }

    public function dataEnd()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], [4, 8, 12]]
        ];
    }

    /**
     * 
     * @dataProvider dataTransform
     */
    public function testTransform($substrings, $callable, $expected)
    {
        $result = $this->makeSubstringList($substrings)
            ->transform($callable)
            ->toArray();
        $this->assertEquals($expected, $result);
    }

    public function dataTransform()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], function($s) {
                    return $s->reverse()->upper();
                }, ['DC', 'HG', 'LK']],
            ' 2. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], function($s) {
                    return $s->length();
                }, ['2', '2', '2']],
            ' 3. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], function($s, SubstringInfo $info) {
                    return $s->prepend($info->before())->append($info->after());
                }, ['abcdef', 'efghij', 'ijklmn']],
        ];
    }

    /**
     * 
     * @dataProvider dataConvert
     */
    public function testConvert($substrings, $callable, $expected)
    {
        $result = $this->makeSubstringList($substrings)
            ->convert($callable);
        $this->assertEquals($expected, $result);
    }

    public function dataConvert()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], function($s) {
                    return $s->reverse()->upper();
                }, ['DC', 'HG', 'LK']],
            ' 2. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], function($s) {
                    return $s->length();
                }, [2, 2, 2]],
            ' 3. ' => [['ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn'], function($s, SubstringInfo $info) {
                    return $info->length();
                }, [2, 2, 2]],
        ];
    }

    /**
     * 
     * @dataProvider dataInfo
     */
    public function testInfo($substrings, $index, $expected)
    {
        $list = $this->makeSubstringList($substrings);
        
        /* @var $info SubstringInfo */
        $info = $list->info()[$index];
        
        $result = [
            $info->index(),
            $info->isFirst(),
            $info->isLast(),
            $info->before(),
            $info->after(),
            $info->start(),
            $info->end(),
            $info->length(),
            $info->isAtLeft(),
            $info->isAtRight(),
            $info->list(),
            $info->fullString()
        ];
        
        $expected[] = $list;
        $expected[] = $list->getString();
        
        $this->assertEquals($expected, $result);
    }

    public function dataInfo()
    {
        return [
            ' 1. ' => [['ab', 'cd', 'ef', 'gh', 'ij'], 0, [0, true, false, 'ab', 'ef', 2, 4, 2, false, false]],
            ' 2. ' => [['ab', 'cd', 'ef', 'gh', 'ij'], 1, [1, false, true, 'ef', 'ij', 6, 8, 2, false, false]],
            ' 3. ' => [['', 'cd', 'ef', 'gh', ''], 0, [0, true, false, '', 'ef', 0, 2, 2, true, false]],
            ' 4. ' => [['', 'cd', 'ef', 'gh', ''], 1, [1, false, true, 'ef', '', 4, 6, 2, false, true]],
        ];
    }

}
