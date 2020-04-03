<?php

namespace Jackal\Downloader\Ext\Youtube\Tests\Filter;

use Jackal\Downloader\Ext\Youtube\Filter\VideoResultFilter;
use Jackal\Downloader\Ext\Youtube\Validator\ValidatorInterface;
use PHPUnit\Framework\TestCase;

class FilterValidatorTest extends TestCase
{
    public function testFilterResults()
    {
        $mockValidator = $this->getMockBuilder(ValidatorInterface::class)->disableOriginalConstructor()->getMock();
        $mockValidator->expects($this->at(0))->method('isValid')->willReturn(true);
        $mockValidator->expects($this->at(1))->method('isValid')->willReturn(false);

        $filter = new VideoResultFilter();
        $filter->setValidator($mockValidator);
        $results = $filter->filter([
            ['format' => '240p audio video', 'url' => 'url_1'],
            ['format' => '360p audio video', 'url' => 'url_2'],
        ]);

        $this->assertEquals([
            '240' => 'url_1',
        ], $results);
    }
}
