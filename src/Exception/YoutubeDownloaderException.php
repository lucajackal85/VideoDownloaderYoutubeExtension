<?php

namespace Jackal\Downloader\Ext\Youtube\Exception;

use Jackal\Downloader\Exception\DownloadException;

class YoutubeDownloaderException extends DownloadException
{
    public static function videoURLsNotFound()
    {
        return new YoutubeDownloaderException('No valid video URLs found');
    }

    public static function formatNotFound($expected, array $available)
    {
        return new YoutubeDownloaderException(sprintf(
            'Format %s is not available. [Available formats are: %s]',
            $expected,
            implode(', ', array_keys($available))
        ));
    }
}
