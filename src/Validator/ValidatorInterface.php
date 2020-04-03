<?php

namespace Jackal\Downloader\Ext\Youtube\Validator;

interface ValidatorInterface
{
    public function isValid($url) : bool ;
}
