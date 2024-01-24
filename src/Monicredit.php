<?php

namespace Jesuferanmi\PhpMonicredit;

use GuzzleHttp\Client;

/**
 * Monicredit API Library for PHP
 * @author Olasunkanmi Jesuferanmi
 */

 class Monicredit
 {
    protected $publicKey;
    protected $privateKey;
    protected $response;
    protected $BaseUrlType;

    public function client($BaseUrlType)
    {
        return new Client(['base_uri' => $this->getBaseURI($BaseUrlType)]);
    }

    public function getBaseURI($BaseUrlType)
    {
        switch ($BaseUrlType){
            case 'DEMO':
                return 'https://demo.backend.monicredit.com/api/v1/';
            case 'LIVE':
                return 'https://live.backend.monicredit.com/api/v1/';
            default:
                break;
        }
    }
 }