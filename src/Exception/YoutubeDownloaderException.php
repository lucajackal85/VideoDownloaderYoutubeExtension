<?php

namespace Jackal\Downloader\Ext\Youtube\Exception;

use Jackal\Downloader\Exception\DownloadException;

class YoutubeDownloaderException extends DownloadException
{
    public static function videoURLsNotFound()
    {
        return new YoutubeDownloaderException('No valid video URLs found');
    }

    public static function formatNotFound(array $selectedFormats, array $available)
    {
        return new YoutubeDownloaderException(sprintf(
            'Format%s %s is not available. [Available formats are: %s]',
            count($selectedFormats) == 1 ? '' : 's',
            implode(', ', $selectedFormats),
            implode(', ', array_keys($available))
        ));
    }
}
