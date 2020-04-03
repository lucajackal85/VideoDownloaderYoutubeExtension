<?php


namespace Jackal\Downloader\Ext\Youtube\Validator;

class CUrlValidator implements ValidatorInterface
{
    public function isValid($url): bool
    {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'HEAD');
        curl_setopt($handle, CURLOPT_TIMEOUT, 5);
        curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        return $httpCode < 400;
    }
}
