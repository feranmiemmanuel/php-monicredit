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
    protected $revenueHeadId;
    protected $customer;
    protected $settlementBankId;
    protected $response;
    protected $baseUrlType;

    public function client(string $baseUrlType)
    {
        return new Client(['base_uri' => $this->getBaseURI($baseUrlType)]);
    }

    public function getBaseURI(string $baseUrlType)
    {
        switch ($baseUrlType){
            case 'DEMO':
                return 'https://demo.backend.monicredit.com/';
            case 'LIVE':
                return 'https://live.backend.monicredit.com/';
            default:
                break;
        }
    }

    protected function post(string $path, array $payload, string $baseUrlType)
    {
        $response = $this->client($baseUrlType)->post(
            'api/v1/' . $path,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => $payload,
            ]
        );

        $this->response = $response;
        return json_decode($response->getBody(), true);
    }

    protected function get(string $path, array $payload, string $baseUrlType)
    {
        $response = $this->client($baseUrlType)->get(
            'api/v1/' . $path,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'query' => $payload,
            ]
        );

        $this->response = $response;
        return json_decode($response->getBody(), true);
    }
 }