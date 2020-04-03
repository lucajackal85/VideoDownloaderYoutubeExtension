<?php

namespace Jackal\Downloader\Ext\Youtube\Tests\Filter;

use Jackal\Downloader\Ext\Youtube\Exception\YoutubeDownloaderException;
use Jackal\Downloader\Ext\Youtube\Filter\VideoResultFilter;
use PHPUnit\Framework\TestCase;

class FilterFormatTest extends TestCase
{
    public function testFilterReturnSingleFormat()
    {
        $filter = new VideoResultFilter();
        $results = $filter->filter([
            ['format' => '360p audio video', 'url' => 'url_1'],
            ['format' => '240p audio video', 'url' => 'url_0'],
            ['format' => '240p audio video', 'url' => 'url_2'],
        ], 240);

        $this->assertEquals(['240' => 'url_0'], $results);
    }

    public function testItShouldRaiseExceptionOnFormatNotFound()
    {
        $this->expectException(YoutubeDownloaderException::class);
        $this->expectExceptionMessage('Format 1080 is not available. [Available formats are: 240, 360]');

        $filter = new VideoResultFilter();
        $filter->filter([
            ['format' => '360p audio video', 'url' => 'url_1'],
            ['format' => '240p audio video', 'url' => 'url_2'],
        ], 1080);
    }

    public function testItShouldRaiseExceptionOnFormatNotFoundEmpyuResults()
    {
        $this->expectException(YoutubeDownloaderException::class);
        $this->expectExceptionMessage('No valid video URLs found');

        $filter = new VideoResultFilter();
        $filter->filter([], 1080);
    }
}
