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

    public function getBaseURI(): string
    {
        switch ($_ENV['MONICREDIT_ENVIRONMENT']){
            case 'DEMO':
                return $_ENV['MONICREDIT_DEMO_BASEURL'];
            case 'LIVE':
                return $_ENV['MONICREDIT_LIVE_BASEURL'];
            default:
                break;
        }
    }

    protected function parsePostRequest(string $path, array $payload)
    {
        $response = $this->client()->post(
            'v1/' . $path,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => $payload,
            ]
        );

        return $this->responseFormater($response);
    }

    protected function parseGetRequest(string $path, array $payload = []): array
    {
        $response = $this->client()->get(
            'v1/' . $path,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'query' => $payload,
            ]
        );

        return $this->responseFormater($response);
    }

    protected function responseFormater($response): array
    {
        return json_decode($response->getBody(), true);
    }

    public function intiateTransaction(array $payload): array
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
        return $this->parsePostRequest('payment/transactions/init-transaction', $payload);
    }

    public function verifyTransaction(array $payload): array
    {
        $privateKey = '';
        if ($_ENV['MONICREDIT_ENVIRONMENT'] == 'DEMO') {
            $privateKey = $_ENV['MONICREDIT_DEMO_PRIVATE_KEY'];
            $payload['private_key'] = $privateKey;
        } elseif ($_ENV['MONICREDIT_ENVIRONMENT'] == 'LIVE') {
            $privateKey = $_ENV['MONICREDIT_LIVE_PRIVATE_KEY'];
            $payload['private_key'] = $privateKey;
        }
        return $this->parsePostRequest('payment/transactions/verify-transaction', $payload);
    }

    public function getInitiatedTransactionInfo(string $payload): array
    {
        return $this->parseGetRequest('payment/transactions/init-transaction-info/' . $payload);
    }
 }