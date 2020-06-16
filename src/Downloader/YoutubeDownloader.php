<?php

namespace Jackal\Downloader\Ext\Youtube\Downloader;

use Jackal\Downloader\Downloader\AbstractDownloader;
use Jackal\Downloader\Ext\Youtube\Filter\VideoResultFilter;
use Jackal\Downloader\Ext\Youtube\Validator\CUrlValidator;

class YoutubeDownloader extends AbstractDownloader
{
    /** @var array $options */
    protected $options;

    /** @var string $youtubeVideoURL */
    protected $youtubeVideoURL;

    /** @var VideoResultFilter $videoFilter */
    protected $videoFilter;

    protected $downloadLinks = [];

    public function __construct($id, array $config = [])
    {
        if(!array_key_exists('allow-no-audio', $config)){
            $config['allow-no-audio'] = false;
        }

        parent::__construct($id, $config);

        $this->videoFilter = new VideoResultFilter($config['allow-no-audio']);
        $this->videoFilter->setValidator(new CUrlValidator());

        $this->youtubeVideoURL = 'https://www.youtube.com/watch?v=' . $this->getVideoId();
    }

    /**
     * @return array
     * @throws \Jackal\Downloader\Ext\Youtube\Exception\YoutubeDownloaderException
     */
    protected function getDownloadLinks() : array{
        if($this->downloadLinks == []) {
            $yt = new \YouTube\YouTubeDownloader();
            $this->downloadLinks = $yt->getDownloadLinks($this->youtubeVideoURL);
            $this->downloadLinks = $this->videoFilter->filter($this->downloadLinks, []);
        }

        return $this->downloadLinks;
    }

    /**
     * @return string
     * @throws \Jackal\Downloader\Exception\DownloadException
     * @throws \Jackal\Downloader\Ext\Youtube\Exception\YoutubeDownloaderException
     */
    public function getURL() : string
    {
        $formatVideos = $this->filterByFormats($this->getDownloadLinks());

        return array_values($formatVideos)[0];
    }

    /**
     * @return array
     * @throws \Jackal\Downloader\Exception\DownloadException
     * @throws \Jackal\Downloader\Ext\Youtube\Exception\YoutubeDownloaderException
     */
    public function getFormatsAvailable(): array
    {
        $formatVideos = $this->filterByFormats($this->getDownloadLinks());

        return array_keys($formatVideos);
    }

    /**
     * @return string
     */
    public static function getPublicUrlRegex(): string
    {
        return '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return 'youtube';
    }
}
