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

    public function filter(array $videos, string $selectedFormat = null) : array
    {
        $outVideos = [];

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

                    if ($selectedFormat and array_key_exists($selectedFormat, $outVideos)) {
                        return [$selectedFormat => $outVideos[$selectedFormat]];
                    }
                }
            }
        }

        ksort($outVideos, SORT_NUMERIC);

        if ($selectedFormat and !array_key_exists($selectedFormat, $outVideos)) {
            throw YoutubeDownloaderException::formatNotFound($selectedFormat, $outVideos);
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
            return isset($match[1]) ? $match[1] : null;
        }
    }
}
