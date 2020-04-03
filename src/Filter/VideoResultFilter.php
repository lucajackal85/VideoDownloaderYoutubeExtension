<?php

namespace Jackal\Downloader\Ext\Youtube\Filter;

use Jackal\Downloader\Ext\Youtube\Exception\YoutubeDownloaderException;
use Jackal\Downloader\Ext\Youtube\Validator\ValidatorInterface;

class VideoResultFilter
{
    protected $validator;

    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    protected function hasValidator() : bool
    {
        return isset($this->validator);
    }

    protected function getValidator() : ?ValidatorInterface
    {
        return $this->validator;
    }

    public function filter(array $videos, array $selectedFormats = []) : array
    {
        $outVideos = [];
        sort($selectedFormats, SORT_NUMERIC);

        foreach ($videos as $video) {
            if (isset($video['format'])) {
                $formatFound = $this->checkContainsAudioAndVideoFormat($video['format']);
                if (isset($formatFound)) {
                    if (array_key_exists($formatFound, $outVideos)) {
                        continue;
                    }
                    if ($this->hasValidator()) {
                        if ($this->getValidator()->isValid($video['url'])) {
                            $outVideos[$formatFound] = $video['url'];
                        }
                    } else {
                        $outVideos[$formatFound] = $video['url'];
                    }

                    if($selectedFormats != []) {
                        foreach ($selectedFormats as $selectedFormat) {
                            if (array_key_exists($selectedFormat, $outVideos)) {
                                return [$selectedFormat => $outVideos[$selectedFormat]];
                            }
                        }
                    }
                }
            }
        }

        if ($outVideos == []) {
            throw YoutubeDownloaderException::videoURLsNotFound();
        }

        ksort($outVideos, SORT_NUMERIC);

        if($selectedFormats != []) {
            foreach ($selectedFormats as $selectedFormat) {
                if (array_key_exists($selectedFormat, $outVideos)) {
                    return [$selectedFormat => $outVideos[$selectedFormat]];
                }
            }

            throw YoutubeDownloaderException::formatNotFound($selectedFormats, $outVideos);
        }

        return $outVideos;
    }

    public function checkContainsAudioAndVideoFormat($string) : ?string
    {
        foreach (['audio', 'video'] as $elem) {
            if (strpos($string, $elem) === false) {
                return null;
            }

            preg_match('/([0-9]{2,4})p/', $string, $match);

            return $match[1] ?? null;
        }
    }
}
