<?php

namespace Jesuferanmi\PhpMonicredit;

use Dotenv\Dotenv;
use GuzzleHttp\Client;

/**
 * Monicredit API Library for PHP
 * @author Olasunkanmi Jesuferanmi
 */
 class Monicredit
 {
    protected $response;
    public $verifySSL = true;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/..");
        $dotenv->load();
    }
    public function client()
    {
        return new Client(['base_uri' => $this->getBaseURI()]);
    }

    public function getBaseURI()
    {
        switch ($_ENV['MONICREDIT_ENVIRONMENT']){
            case 'DEMO':
                return 'https://demo.backend.monicredit.com/';
            case 'LIVE':
                return 'https://live.backend.monicredit.com/';
            default:
                break;
        }
    }

    protected function post(string $path, array $payload)
    {
        $response = $this->client()->post(
            'api/v1/' . $path,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => $payload,
            ]
        );

        $this->response = $response;
        return json_decode($response->getBody(), true);
    }

    protected function get(string $path, array $payload)
    {
        $response = $this->client()->get(
            'api/v1/' . $path,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'query' => $payload,
            ]
        );

        $this->response = $response;
        return json_decode($response->getBody(), true);
    }

    public function intiateTransaction(array $payload)
    {
        $publicKey = '';
        if ($_ENV['MONICREDIT_ENVIRONMENT'] == 'DEMO') {
            $publicKey = $_ENV['MONICREDIT_DEMO_PUBLIC_KEY'];
            $payload['public_key'] = $publicKey;
        } elseif ($_ENV['MONICREDIT_ENVIRONMENT'] == 'LIVE') {
            $publicKey = $_ENV['MONICREDIT_LIVE_PUBLIC_KEY'];
            $payload['public_key'] = $publicKey;
        }
        $payload["paytype"] = "standard";
        return $this->post('payment/transactions/init-transaction', $payload);
    }
 }