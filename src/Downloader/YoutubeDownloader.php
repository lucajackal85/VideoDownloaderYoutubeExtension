<?php

namespace Jackal\Downloader\Ext\Youtube\Downloader;

use Jackal\Downloader\Downloader\AbstractDownloader;
use Jackal\Downloader\Ext\Youtube\Filter\VideoResultFilter;
use Jackal\Downloader\Ext\Youtube\Validator\CUrlValidator;

class YoutubeDownloader extends AbstractDownloader
{
    const VIDEO_TYPE = 'youtube';

    /** @var array $options */
    protected $options;
    /** @var string $youtubeVideoURL */
    protected $youtubeVideoURL;

    public function getURL() : string
    {
        $this->youtubeVideoURL = 'https://www.youtube.com/watch?v=' . $this->getVideoId();

        $yt = new \YouTube\YouTubeDownloader();
        $links = $yt->getDownloadLinks($this->youtubeVideoURL);

        $videoFilter = new VideoResultFilter();
        $videoFilter->setValidator(new CUrlValidator());
        $formatVideos = $videoFilter->filter($links, $this->getFormats());

        $formatVideos = $this->filterByFormats($formatVideos);

        return array_values($formatVideos)[0];
    }
}
