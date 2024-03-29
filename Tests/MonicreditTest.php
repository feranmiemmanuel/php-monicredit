<?php

namespace Tests;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Jesuferanmi\PhpMonicredit\traits\HttpRequestTrait;
use Jesuferanmi\PhpMonicredit\Monicredit;

class MonicreditTest extends TestCase
{
    use HttpRequestTrait;
 
    protected $verifySSL = false;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $dotenv = Dotenv::createImmutable(__DIR__ . "/..");
        $dotenv->load();
    }

    public function test_initiate_transaction()
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
            'feeBearer' => 'merchant'
        ];

        $initiate = $monicredit->intiateTransaction($payload);
    
        $this->assertIsArray($initiate);
        $this->assertArrayHasKey("status", $initiate);
        $this->assertArrayHasKey("authorization_url", $initiate);
        $this->assertArrayHasKey("id", $initiate);
        unset($initiate);
    }

    public function test_verify_transaction()
    {
        // Disable Verify SSL in Guzzle
        $monicredit = new Monicredit();
        $monicredit->verifySSL = $this->verifySSL;
        $payload = ["transaction_id" => "ACX65B195953530D"];
        $verify = $monicredit->verifyTransaction($payload);

        $this->assertIsArray($verify);
        $this->assertArrayHasKey("status", $verify);
        $this->assertArrayHasKey("orderid", $verify);
        $this->assertArrayHasKey("data", $verify);
        $this->assertIsArray($verify, "data");
        unset($verify);
    }

    public function test_get_initiated_transaction_info()
    {
        $monicredit = new Monicredit();
        $monicredit->verifySSL = $this->verifySSL;
        $payload = "ACX65B195953530D";
        $getInfo = $monicredit->getInitiatedTransactionInfo($payload);

        $this->assertIsArray($getInfo);
        $this->assertArrayHasKey("status", $getInfo);
        $this->assertArrayHasKey("data", $getInfo);
        $this->assertIsArray($getInfo, "data");
        unset($getInfo);
    }
}