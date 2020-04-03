<?php

namespace Jackal\Downloader\Ext\Youtube\Tests\Filter;

use Jackal\Downloader\Ext\Youtube\Exception\YoutubeDownloaderException;
use Jackal\Downloader\Ext\Youtube\Filter\VideoResultFilter;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    public function testFilterResultsNoValidator()
    {
        $filter = new VideoResultFilter();
        $results = $filter->filter([
            ['format' => '240p audio video', 'url' => 'url_1'],
            ['format' => '360p audio video', 'url' => 'url_2'],
        ]);

        $this->assertEquals([
            '240' => 'url_1',
            '360' => 'url_2',
        ], $results);
    }

    public function testFilterRemoveInvalidFormats()
    {
        $filter = new VideoResultFilter();
        $results = $filter->filter([
            ['format' => '240p audio video', 'url' => 'url_1'],
            ['format' => '360p audio video', 'url' => 'url_2'],
            ['format' => 'invalid','url' => 'url_3'], //will remove
        ]);

        $this->assertEquals([
            '240' => 'url_1',
            '360' => 'url_2',
        ], $results);
    }

    public function testFilterRemoveDuplicates()
    {
        $filter = new VideoResultFilter();
        $results = $filter->filter([
            ['format' => '240p audio video', 'url' => 'url_0'],
            ['format' => '240p audio video', 'url' => 'url_1'],
            ['format' => '360p audio video', 'url' => 'url_2'],
        ]);

        $this->assertEquals([
            '240' => 'url_0',
            '360' => 'url_2',
        ], $results);
    }

    public function testFilterReoredFormats()
    {
        $filter = new VideoResultFilter();
        $results = $filter->filter([
            ['format' => '360p audio video', 'url' => 'url_2'],
            ['format' => '240p audio video', 'url' => 'url_1'],
        ]);

        $this->assertEquals([
            '240' => 'url_1',
            '360' => 'url_2',
        ], $results);
    }

    public function testItShouldRaiseExceptionOnEmptyResults()
    {
        $this->expectException(YoutubeDownloaderException::class);
        $this->expectExceptionMessage('No valid video URLs found');

        $filter = new VideoResultFilter();
        $results = $filter->filter([]);
    }
}
