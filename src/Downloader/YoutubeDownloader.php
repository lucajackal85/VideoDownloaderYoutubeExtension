<?php

namespace Jackal\Downloader\Ext\Youtube\Downloader;

use Jackal\Downloader\Downloader\AbstractDownloader;

class YoutubeDownloader extends AbstractDownloader
{
    const VIDEO_TYPE = 'youtube';

    /** @var array $options */
    protected $options;
    /** @var string $youtubeVideoURL */
    protected $youtubeVideoURL;

    public function getURL() : string
    {
        if (!filter_var($this->getVideoId(), FILTER_VALIDATE_URL)) {
            $this->youtubeVideoURL = 'https://www.youtube.com/watch?v=' . $this->getVideoId();
        }

        $yt = new \YouTube\YouTubeDownloader();
        $links = $yt->getDownloadLinks($this->youtubeVideoURL);

        $videos = array_values($links);

        $formatVideos = [];

        foreach ($videos as $video) {
            if (isset($video['format'])) {
                preg_match('/([0-9]{2,4})p/', $video['format'], $match);
                if (isset($match[1])) {
                    $formatVideos[$match[1]] = $video['url'];
                }
            }
        }

        ksort($formatVideos, SORT_NUMERIC);

        if ($this->getFormat() and !isset($formatVideos[$this->getFormat()])) {
            throw new \Exception(
                sprintf(
                    'Format %s is not available. [Available formats are: %s]',
                    $this->getFormat(),
                    implode(', ', array_keys($formatVideos))
                )
            );
        }

        return $this->getFormat() ? $formatVideos[$this->getFormat()] : end($formatVideos);
    }

    protected function getFormat() : ?string
    {
        return $this->options['format'];
    }
}
