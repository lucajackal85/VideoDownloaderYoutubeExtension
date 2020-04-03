<?php

namespace Jackal\Downloader\Ext\Youtube\Filter;

class VideoResultFilter
{
    public function filter(array $videos, string $selectedFormat = null) : array{
        $outVideos = [];

        foreach ($videos as $video){
            if (isset($video['format'])) {
                preg_match('/([0-9]{2,4})p/', $video['format'], $match);
                if (isset($match[1])) {
                        if(array_key_exists($match[1], $outVideos)){
                            continue;
                        }
                        if($this->isValidHTTPURL($video['url'])){
                            $outVideos[$match[1]] = $video['url'];
                        }

                        if(array_key_exists($selectedFormat, $outVideos)){
                            break;
                        }
                }
            }
        }

        ksort($outVideos, SORT_NUMERIC);

        return $outVideos;

    }

    protected function isValidHTTPURL(string $url) : bool {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'HEAD');
        curl_setopt($handle, CURLOPT_TIMEOUT, 5);
        curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        return $httpCode < 400;
    }
}