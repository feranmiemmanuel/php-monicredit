<?php

namespace Jesuferanmi\PhpMonicredit\traits;

use GuzzleHttp\Client;

trait HttpRequestTrait
{
    protected function client()
    {
        return new Client(['base_uri' => $this->getBaseURI()]);
    }

    protected function getBaseURI(): string
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

    protected function getPrivateKey(): string
    {
        $privateKey = '';
        if ($_ENV['MONICREDIT_ENVIRONMENT'] == 'DEMO') {
            $privateKey = $_ENV['MONICREDIT_DEMO_PRIVATE_KEY'];
        } elseif ($_ENV['MONICREDIT_ENVIRONMENT'] == 'LIVE') {
            $privateKey = $_ENV['MONICREDIT_LIVE_PRIVATE_KEY'];
        }
        return $privateKey;
    }

    protected function getPublicKey(): string
    {
        $publicKey = '';
        if ($_ENV['MONICREDIT_ENVIRONMENT'] == 'DEMO') {
            $publicKey = $_ENV['MONICREDIT_DEMO_PUBLIC_KEY'];
        } elseif ($_ENV['MONICREDIT_ENVIRONMENT'] == 'LIVE') {
            $publicKey = $_ENV['MONICREDIT_LIVE_PUBLIC_KEY'];
        }
        return $publicKey;
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
}
