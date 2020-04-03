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

        return array_shift(array_slice($formatVideos, 0, 1));
    }

    protected function getFormats() : array
    {
        if(!isset($this->options['format'])){
            return [];
        }

        if(!is_array($this->options['format'])){
            return [$this->options['format']];
        }

        return $this->options['format'];

    }
}
