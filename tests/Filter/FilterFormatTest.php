<?php

namespace Jackal\Downloader\Ext\Youtube\Tests\Filter;

use Jackal\Downloader\Exception\DownloadException;
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
        ], [240]);

        $this->assertEquals(['240' => 'url_0'], $results);
    }

    public function testFilterReturnMultipleFormat()
    {
        $filter = new VideoResultFilter();
        $results = $filter->filter([
            ['format' => '144p audio video', 'url' => 'url_0'],
            ['format' => '360p audio video', 'url' => 'url_1'],
            ['format' => '480p audio video', 'url' => 'url_2'],
        ], [240,360]);

        $this->assertEquals(['360' => 'url_1'], $results);
    }

    public function testFilterReturnMultipleFormatInversed()
    {
        $filter = new VideoResultFilter();
        $results = $filter->filter([
            ['format' => '360p audio video', 'url' => 'url_1'],
            ['format' => '480p audio video', 'url' => 'url_2'],
        ], [240,480,360]);

        $this->assertEquals(['360' => 'url_1'], $results);
    }

    public function testItShouldRaiseExceptionOnFormatNotFoundEmpyuResults()
    {
        $this->expectException(YoutubeDownloaderException::class);
        $this->expectExceptionMessage('No valid video URLs found');

        $filter = new VideoResultFilter();
        $filter->filter([], [1080]);
    }
}
