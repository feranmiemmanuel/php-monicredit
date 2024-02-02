<?php

namespace Jesuferanmi\PhpMonicredit;

use Jesuferanmi\PhpMonicredit\traits\HttpRequestTrait;
use Dotenv\Dotenv;

/**
 * Monicredit API Library for PHP
 * @author Olasunkanmi Jesuferanmi
 */
 class Monicredit
 {
    use HttpRequestTrait;
    protected $response;
    public $verifySSL = true;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/..");
        $dotenv->load();
    }

    public function intiateTransaction(array $payload): array
    {
        $payload['public_key'] = $this->getPublicKey();
        $payload["paytype"] = "standard";
        return $this->parsePostRequest('payment/transactions/init-transaction', $payload);
    }

    public function verifyTransaction(array $payload): array
    {
        $payload['private_key'] = $this->getPrivateKey();
        return $this->parsePostRequest('payment/transactions/verify-transaction', $payload);
    }

    public function getInitiatedTransactionInfo(string $payload): array
    {
        return $this->parseGetRequest('payment/transactions/init-transaction-info/' . $payload);
    }
 }