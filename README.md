# VideoDownloaderYoutubeExtension
[![Latest Stable Version](https://poser.pugx.org/jackal/video-downloader-ext-youtube/v/stable)](https://packagist.org/packages/jackal/video-downloader-ext-youtube)
[![Total Downloads](https://poser.pugx.org/jackal/video-downloader-ext-youtube/downloads)](https://packagist.org/packages/jackal/video-downloader-ext-youtube)
[![Latest Unstable Version](https://poser.pugx.org/jackal/video-downloader-ext-youtube/v/unstable)](https://packagist.org/packages/jackal/video-downloader-ext-youtube)
[![License](https://poser.pugx.org/jackal/video-downloader-ext-youtube/license)](https://packagist.org/packages/jackal/video-downloader-ext-youtube)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lucajackal85/VideoDownloaderYoutubeExtension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lucajackal85/VideoDownloaderYoutubeExtension/?branch=master)


**Youtube extension for [jackal/video-downloader](https://github.com/lucajackal85/VideoDownloader)**

## Installation
```
composer require jackal/video-downloader-ext-youtube
```

## Usage
```
use Jackal\Downloader\Ext\Youtube\Downloader\YoutubeDownloader;

require_once __DIR__ . '/vendor/autoload.php';

$youtubeVideoId = 'otCpCn0l4Wo';

$vd = new \Jackal\Downloader\VideoDownloader();
$vd->registerDownloader(YoutubeDownloader::VIDEO_TYPE, YoutubeDownloader::class);

$downloader = $vd->getDownloader(YoutubeDownloader::VIDEO_TYPE, $youtubeVideoId, [
    'format' => [360,480]
]);

$downloader->download(__DIR__ . '/output.avi');
```
