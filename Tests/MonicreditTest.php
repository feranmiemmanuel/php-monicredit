<?php

namespace Tests;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Jesuferanmi\PhpMonicredit\Monicredit;

class MonicreditTest extends TestCase
{
    protected $verifySSL = false;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $dotenv = Dotenv::createImmutable(__DIR__ . "/..");
        $dotenv->load();
    }

    public function test_initiate_index()
    {
        $monicredit = new Monicredit();

        // Disable Verify SSL in Guzzle
        $monicredit->verifySSL = $this->verifySSL;

        $customer = [
            'first_name' => 'Olasunkanmi',
            'last_name' => 'Feranmi',
            'email' => 'feranmiolasunkanmi91@gmail.com',
            'phone' => '0000000002'
        ];

        $splitDetails = [
            'sub_account_code' => 'SB649AD89575E69 ',
            'fee_percentage' => 100,
            'fee_flat' => 0
        ];
        $itemDetails = [
            "item" => 'Test Transaction',
            "revenue_head_code" => 'REV649AD8957E0E1',
            "unit_cost" => '300',
            "split_details" => array($splitDetails),
        ];

        $payload = [
            'order_id' => rand(1000, 9000),
            'customer' => $customer,
            'items' => [$itemDetails],
            'transaction_type' => 'POS',
            'feeBearer' => 'merchant'
        ];

        $initiate = $monicredit->intiateTransaction($payload);
        $this->assertIsArray($initiate);
        $this->assertArrayHasKey("status", $initiate);
        $this->assertArrayHasKey("authorization_url", $initiate);
        $this->assertArrayHasKey("id", $initiate);
        unset($initiate);
    }
}