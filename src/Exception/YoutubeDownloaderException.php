<?php

namespace Jackal\Downloader\Ext\Youtube\Exception;

use Jackal\Downloader\Exception\DownloadException;

class YoutubeDownloaderException extends DownloadException
{
    public static function videoURLsNotFound(){
        return new YoutubeDownloaderException('No video URLs found');
    }
}