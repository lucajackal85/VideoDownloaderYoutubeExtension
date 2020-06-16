<?php

use Jackal\Downloader\Ext\Youtube\Downloader\YoutubeDownloader;

require_once __DIR__ . '/vendor/autoload.php';

$youtube = '9jfWwxfGoFI';

$vd = new \Jackal\Downloader\VideoDownloader();
$vd->registerDownloader(YoutubeDownloader::class);

$downloader = $vd->getDownloader(YoutubeDownloader::getType(), $youtube);

var_dump($downloader->getFormatsAvailable());exit;

$downloader->download(__DIR__ . '/test.avi');